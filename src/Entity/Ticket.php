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
     * @ORM\Column(type="boolean")
     */
    private $reducted_price;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $lastname;

    /**
     * @return mixed
     */
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
     *     inversedBy="ticketCollection"
     * )
     * @ORM\JoinColumn(name="ordernumber",
     * referencedColumnName="ticketnumber")
     */
    private $ticketCollection;

    /**
     * @ORM\Column(type="string")
     */
    private $ticket_number;

    /**
     * Ticket constructor.
     */
    public function __construct()
    {
        $this->ticketCollection = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|null
     */
    public function getTicketCollection(): array
    {
        return $this->ticketCollection;
    }

    /**
     * @param mixed $ticketCollection
     */
    public function setTicketCollection($ticketCollection): void
    {
        $this->ticketCollection = $ticketCollection;
    }

    /**
     * @return mixed
     */
    public function getReductedPrice()
    {
        return $this->reducted_price;
    }

    /**
     * @param mixed $reducted_price
     */
    public function setReductedPrice($reducted_price): void
    {
        $this->reducted_price = $reducted_price;
    }

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
     * @return mixed
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
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
     * @param $lastname
     */
    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
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
     * @return mixed
     */
    public function getTicketNumber()
    {
        return $this->ticket_number;
    }
}
