namespace App\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Application\Service\CancelOrderService;
use App\Application\Service\SearchOrderService;
use App\Application\Service\PaginateOrdersService;

class OrderController extends AbstractController
{
    private $cancelOrderService;
    private $searchOrderService;
    private $paginateOrdersService;

    public function __construct(
        CancelOrderService $cancelOrderService,
        SearchOrderService $searchOrderService,
        PaginateOrdersService $paginateOrdersService
    ) {
        $this->cancelOrderService = $cancelOrderService;
        $this->searchOrderService = $searchOrderService;
        $this->paginateOrdersService = $paginateOrdersService;
    }

    public function cancelOrder($orderId)
    {
        $this->cancelOrderService->execute($orderId);
        return new Response('Order cancelled', 200);
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
        $orders = $this->paginateOrdersService->execute($page);
        return $this->json($orders);
    }
}