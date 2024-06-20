<?php
namespace App\Application\Service;
use App\Domain\Repository\OrderRepositoryInterface;

class OrderService
{
    private $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function cancelOrder($orderId)
    {
        $order = $this->orderRepository->findById($orderId);
        if ($order) {
            $order->setStatus('cancelled');
            $this->orderRepository->save($order);
			return true;
        }
		return false;
    }

	public function paginateOrders($page, $limit = 10)
    {
        return $this->orderRepository->paginate($page, $limit);
    }

	public function searchOrdersByCustomerName($customerName)
	{
		return $this->orderRepository->searchOrdersByCustomerName($customerName);
	}
}