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
        
		return $this->orderRepository->cancelOrder($orderId);
    }

	public function getOrders()
    {
        return $this->orderRepository->getOrders();
    }

	public function searchByCustomerName($customerName)
	{
		return $this->orderRepository->searchByCustomerName($customerName);
	}

	public function searchByStatus($status)
	{
		return $this->orderRepository->searchByStatus($status);
	}

	public function findById($orderId)
	{
		return $this->orderRepository->findById($orderId);	
	}
}