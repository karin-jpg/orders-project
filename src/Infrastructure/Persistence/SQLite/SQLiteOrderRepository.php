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
	public function findPersonById(int $personId): ?Person
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

    public function findByCustomerOrStatus($person_id, $status): array
    {

		return [];
        
    }

    public function save(Order $order): void
    {
        
    }

    public function paginate($page, $limit): array
    {
		$queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('*')
            ->from('orders')
            ->setMaxResults($limit)
            ->setFirstResult($page);

		$statement = $queryBuilder->executeQuery();
		return $statement->fetchAllAssociative();
    }
}