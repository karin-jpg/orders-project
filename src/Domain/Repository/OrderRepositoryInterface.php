<?php
namespace App\Domain\Repository;

use App\Domain\Model\Order;
use App\Domain\Model\Person;

interface OrderRepositoryInterface
{
    public function findById($id): array;
	public function findPersonById($personId): ?Person;
	public function paginate($page, $limit): array;
	public function searchByCustomerName($name): array;
	public function cancelOrder($orderId): array;	
}