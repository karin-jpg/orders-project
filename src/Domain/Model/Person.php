<?php
namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="persons")
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

	/**
     * @ORM\Column(type="string")
     */
    private $address;

	/**
     * @ORM\Column(type="string")
     */
    private $city;

	/**
     * @ORM\Column(type="string")
     */
    private $postcode;

	/**
     * @ORM\Column(type="string")
     */
    private $country;


	public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

	public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

	public function setPostCode(string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

	public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }
}