<?php
namespace App\Infrastructure\Persistence\SQLite;


use App\Domain\Repository\OrderRepositoryInterface;
use App\Domain\Model\Order;
use App\Domain\Model\Person;
use Doctrine\DBAL\Connection;


class SQLiteOrderRepository implements OrderRepositoryInterface
{
    private $connection;

	public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

	public function cancelOrder($orderId): array 
	{
		
		$queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
			->update('orders')
			->set('status', ':status')
			->where('id = :id')
			->setParameter('status', 'cancelled')
			->setParameter('id', $orderId);

		$affectedRows = $queryBuilder->executeStatement($queryBuilder->getSQL(), $queryBuilder->getParameters());
		return [
			"affectedRows" => $affectedRows,
			"order" => $this->findById($orderId)
		];
		 

	}

    public function findById($id): array
    {

		$queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('orders.id, orders.date, persons.name as customer, persons.address as address1, persons.city, persons.postcode, persons.country, orders.amount, orders.status, orders.deleted, orders.last_modified')
            ->from('orders')
			->join('orders', 'persons', 'persons', 'orders.person_id = persons.id')
            ->where('orders.id = :id')
            ->setParameter('id', $id);

		$statement = $queryBuilder->executeQuery();
		return $statement->fetchAllAssociative();

    }

	#Should be on the person SQLITE repository
	public function findPersonById($personId, $json = false): ?Person
    {

		$queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('*')
            ->from('persons')
            ->where('id = :id')
            ->setParameter('id', $personId);

		$statement = $this->connection->executeQuery($queryBuilder->getSQL(), $queryBuilder->getParameters());
		$result = $statement->fetchAssociative();

        if (!$result) {
            return null;
        }

        $person = new Person();
        $person->setValuesFromDatabase($result);

        return $person;
    }

    public function getOrders(): array
    {
		$queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('orders.id, orders.date, persons.name as customer, persons.address as address1, persons.city, persons.postcode, persons.country, orders.amount, orders.status, orders.deleted, orders.last_modified')
            ->from('orders')
			->join('orders', 'persons', 'persons', 'orders.person_id = persons.id');
		$statement = $queryBuilder->executeQuery();
		return $statement->fetchAllAssociative();
    }

	public function searchByCustomerName($name): array
	{
		$queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('orders.id, orders.date, persons.name as customer, persons.address as address1, persons.city, persons.postcode, persons.country, orders.amount, orders.status, orders.deleted, orders.last_modified')
            ->from('orders')
			->join('orders', 'persons', 'persons', 'orders.person_id = persons.id')
			->where($queryBuilder->expr()->like('persons.name', ':name'))
			->setParameter('name', '%' . $name . '%');

		$statement = $this->connection->executeQuery($queryBuilder->getSQL(), $queryBuilder->getParameters());
		return $statement->fetchAllAssociative();		
	}

	public function searchByStatus($status): array
	{
		$queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('orders.id, orders.date, persons.name as customer, persons.address as address1, persons.city, persons.postcode, persons.country, orders.amount, orders.status, orders.deleted, orders.last_modified')
            ->from('orders')
			->join('orders', 'persons', 'persons', 'orders.person_id = persons.id')
            ->where('orders.status = :status')
            ->setParameter('status', $status);

		$statement = $this->connection->executeQuery($queryBuilder->getSQL(), $queryBuilder->getParameters());
		return $statement->fetchAllAssociative();		
	}
}