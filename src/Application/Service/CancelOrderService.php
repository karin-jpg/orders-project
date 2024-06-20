<?php
namespace App\Application\Service;
use App\Domain\Model\OrderRepositoryInterface;

class CancelOrderService
{
    private $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function execute($orderId)
    {
        $order = $this->orderRepository->findById($orderId);
        if ($order) {
            $order->cancel();
            $this->orderRepository->save($order);
        }
    }
}