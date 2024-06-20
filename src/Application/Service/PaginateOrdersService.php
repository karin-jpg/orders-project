<?php
namespace App\Application\Service;

use App\Domain\Model\OrderRepositoryInterface;

class PaginateOrdersService
{
    private $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function execute($page, $limit = 10)
    {
        return $this->orderRepository->paginate($page, $limit);
    }
}