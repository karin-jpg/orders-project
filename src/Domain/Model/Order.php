<?php
namespace App\Domain\Model;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */
class Order
{
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


	/**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id", nullable=false)
     */
    private $person;
	
	/**
     * @ORM\Column(type="string")
     */
    private $status;

	/**
     * @ORM\Column(type="integer")
     */
    private $amount;

	/**
     * @ORM\Column(type="string")
     */
    private $deleted;

	/**
     * @ORM\Column(type="datetime")
     */
    private $last_modified;

	

	public function getId(): ?int
    {
        return $this->id;
    }

	public function setId(int $id): self
    {
		$this->id = $id;
        return $this;
    }

    public function setPerson(Person $person): self
    {
        $this->person = $person;

        return $this;
    }

	public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

	public function setDeleted(string $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

	public function setDate(DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

	public function setLastModified(DateTime $last_modified): self
    {
        $this->$last_modified = $last_modified;

        return $this;
    }
}