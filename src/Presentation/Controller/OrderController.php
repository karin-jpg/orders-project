<?php
namespace App\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Application\Service\OrderService;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrderController extends AbstractController
{
	private $orderService;

    public function __construct(
		OrderService $orderService
    ) {
		$this->orderService = $orderService;
    }

    public function cancelOrder($orderId): Response
    {
        $order = $this->orderService->cancelOrder($orderId);
        if ($order['affectedRows']) {
			return $this->json($order);
		}
		return new Response('Order not found!', 400);
		
    }


    public function getOrders(): JsonResponse
    {
        $orders = $this->orderService->getOrders();
        return $this->json($orders);
    }

	public function searchByCustomerName(Request $request): JsonResponse
    {
		$jsonData = json_decode($request->getContent(), true);
		$customerName = $jsonData['name'];
        $orders = $this->orderService->searchByCustomerName($customerName);
        return $this->json($orders);
    }

	public function searchByStatus(Request $request): JsonResponse
    {
		$jsonData = json_decode($request->getContent(), true);
		$status = $jsonData['status'];
        $orders = $this->orderService->searchByStatus($status);
        return $this->json($orders);
    }

	public function findById($orderId): JsonResponse
	{
		$order = $this->orderService->findById($orderId, true);
		return $this->json($order);
	}
}