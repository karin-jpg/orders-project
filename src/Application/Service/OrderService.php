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

	public function paginateOrders($page, $limit = 10)
    {
        return $this->orderRepository->paginate($page, $limit);
    }

	public function searchByCustomerName($customerName)
	{
		return $this->orderRepository->searchByCustomerName($customerName);
	}

	public function findById($orderId)
	{
		return $this->orderRepository->findById($orderId);	
	}
}