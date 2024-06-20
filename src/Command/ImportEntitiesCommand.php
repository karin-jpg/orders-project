<?php
namespace App\Command;

use App\Domain\Model\Order;
use App\Domain\Model\Person;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportEntitiesCommand extends Command
{
    protected static $defaultName = 'app:import-entities';
    private $entityManager;
	private $success = 0;
	private $failure = 1;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Import entities from a JSON file')
            ->addArgument('file', InputArgument::REQUIRED, 'Path to the JSON file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filePath = $input->getArgument('file');

        if (!file_exists($filePath)) {
            $io->error(sprintf('File "%s" does not exist.', $filePath));
            return $this->failure;
        }

        $jsonData = file_get_contents($filePath);
        $data = json_decode($jsonData, true);

        if ($data === null) {
            $io->error('Invalid JSON data.');
            return $this->failure;
        }

        foreach ($data as $orderDetails) {
            $person = new Person();
            $person->setName($orderDetails['customer']);
			$person->setAddress($orderDetails['address1']);
			$person->setCity($orderDetails['city']);
			$person->setPostCode($orderDetails['postcode']);
			$person->setCountry($orderDetails['country']);

            $order = new Order();
			$order->setId($orderDetails['id']);
            $order->setPerson($person);
			$order->setDate(new \DateTime($orderDetails['date']));
            $order->setAmount($orderDetails['amount']);
			$order->setStatus($orderDetails['status']);
			$order->setDeleted($orderDetails['deleted']);
            $order->setLastModified(new \DateTime($orderDetails['last_modified']));

            $this->entityManager->persist($person);
            $this->entityManager->persist($order);
        }

        $this->entityManager->flush();

        $io->success('Entities have been successfully imported.');

        return $this->success;
    }
}