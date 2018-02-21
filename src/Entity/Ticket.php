<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketRepository")
 * @ORM\Entity
 * @ORM\Table(name="ticket")
 */
class Ticket
{
    /**
     * @return mixed
     */
    public function getTicketPrice()
    {
        return $this->ticket_price;
    }

    /**
     * @param mixed $ticket_price
     */
    public function setTicketPrice($ticket_price): void
    {
        $this->ticket_price = $ticket_price;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="Tickets.php")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * Ticket constructor.
     */
    public function __construct()
    {
        $this->ticket_number = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @return mixed
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @return \DateTime|null
     */
    public function getBirthdate(): ?\DateTime
    {
        return $this->birthdate;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    /**
     * @param mixed $birthdate
     */
    public function setBirthdate($birthdate): void
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @param mixed $ticket_number
     */
    public function setTicketNumber($ticket_number): void
    {
        $this->ticket_number = $ticket_number;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string")
     */
    private $country;

    /**
     * @ORM\Column(type="date")
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string")
     */
    private $ticket_price;

    /**
     * @ORM\Column(type="string")
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\TicketOrder",
     *     inversedBy="order_number"
     * )
     * @ORM\JoinColumn(name="ordernumber",
     * referencedColumnName="ticketnumber")
     */
    private $ticket_number;

    /**
     * @return ArrayCollection|null
     */
    public function getTicketNumber(): ?array
    {
        return $this->ticket_number;
    }
}
