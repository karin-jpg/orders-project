namespace App\Application\Service;

use App\Domain\Model\OrderRepositoryInterface;

class SearchOrderService
{
    private $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function execute($customer, $status)
    {
        return $this->orderRepository->findByCustomerOrStatus($customer, $status);
    }
}