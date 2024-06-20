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
		$sql = 'SELECT * FROM orders WHERE id = :id';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $id);
        // $stmt->execute();
        $result = $stmt->fetch();

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
        $sql = 'SELECT * FROM persons WHERE id = :id';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $personId);
        // $stmt->execute();
        $result = $stmt->fetch();

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
		return [];
    }
}