<?php
namespace App\Infrastructure\Persistence\SQLite;


use App\Domain\Repository\OrderRepositoryInterface;
use App\Domain\Model\Order;
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
		
    }

    public function findByCustomerOrStatus($customer, $status): array
    {
        
    }

    public function save(Order $order): void
    {
        
    }

    public function paginate($page, $limit): array
    {
        
    }
}