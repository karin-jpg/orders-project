namespace App\Domain\Model;

class Order
{
    private $id;
    private $customer;
    private $status;
    private $createdAt;

    public function cancel()
    {
        $this->status = 'cancelled';
    }
}