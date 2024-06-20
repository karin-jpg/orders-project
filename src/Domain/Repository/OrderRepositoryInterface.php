<?php
namespace App\Domain\Repository;

use App\Domain\Model\Order;

interface OrderRepositoryInterface
{
    public function findById($id): ?Order;
    public function findByCustomerOrStatus($customer, $status): array;
    public function save(Order $order): void;
    public function paginate($page, $limit): array;
}