namespace App\Infrastructure\Persistence\SQLite;

use App\Domain\Model\Order;
use App\Domain\Model\OrderRepositoryInterface;

class SQLiteOrderRepository implements OrderRepositoryInterface
{
    private $connection;

    public function __construct(\PDO $connection)
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