<?php
namespace App\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Application\Service\OrderService;
use App\Application\Service\SearchOrderService;

class OrderController extends AbstractController
{
	private $orderService;
    private $searchOrderService;

    public function __construct(
		OrderService $orderService,
        SearchOrderService $searchOrderService,
    ) {
		$this->orderService = $orderService;
        $this->searchOrderService = $searchOrderService;
    }

    public function cancelOrder($order_id)
    {
        $cancelled = $this->orderService->cancelOrder($order_id);
        if ($cancelled) {
			return new Response('Order cancelled!', 200);
		}
		return new Response('Order not found!', 400);
		
    }

    public function searchOrders(Request $request)
    {
        $customer = $request->query->get('customer');
        $status = $request->query->get('status');
        $orders = $this->searchOrderService->execute($customer, $status);
        return $this->json($orders);
    }

    public function paginateOrders($page)
    {
        $orders = $this->orderService->paginateOrders($page);
        return $this->json($orders);
    }

	public function searchOrdersByCustomerName(Request $request)
    {
		$jsonData = json_decode($request->getContent(), true);
		$customerName = $jsonData['name'];
        $orders = $this->orderService->searchOrdersByCustomerName($customerName);
        return $this->json($orders);
    }
}