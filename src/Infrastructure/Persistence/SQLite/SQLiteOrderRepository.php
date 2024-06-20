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

    public function findById($id): ?Order
    {
		$queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('*')
            ->from('orders')
            ->where('id = :id')
            ->setParameter('id', $id);

		$statement = $this->connection->executeQuery($queryBuilder->getSQL(), $queryBuilder->getParameters());
		$result = $statement->fetchAssociative();
        
		if (!$result) {
            return null;
        }

        $order = new Order();
        $order->setValuesFromDatabase($result);
        $person = $this->findPersonById($result['person_id']);
		$order->setPerson($person);

        return $order;
    }

	#Should be on the person SQLITE repository
	public function findPersonById($personId): ?Person
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

    public function paginate($page, $limit): array
    {
		if($page < 1) {
			$page = 1;
		}
		$queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('orders.id, orders.date, persons.name as customer, persons.address as address1, persons.city, persons.postcode, persons.country, orders.amount, orders.status, orders.deleted, orders.last_modified')
            ->from('orders')
			->join('orders', 'persons', 'persons', 'orders.person_id = persons.id')
            ->setMaxResults($limit)
            ->setFirstResult($limit * ($page - 1));

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
            ->where('persons.name = :name')
            ->setParameter('name', $name);

		$statement = $this->connection->executeQuery($queryBuilder->getSQL(), $queryBuilder->getParameters());
		return $statement->fetchAllAssociative();		
	}
}