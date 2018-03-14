<?php

namespace App\Entity;

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
    private $reducedPrice;

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
     * @ORM\Column(type="integer")
     */
    private $ticketPrice;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\TicketOrder",
     *     inversedBy="ticketCollection"
     * )
     * @ORM\JoinColumn(name="ticket_order_id",
     * referencedColumnName="id")
     */
    private $ticketOrder;

    /**
     * @ORM\Column(type="string")
     */
    private $ticketNumber;

    /**
     * @return TicketOrder
     */
    public function getTicketOrder(): TicketOrder
    {
        return $this->ticketOrder;
    }

    /**
     * @param TicketOrder $ticketOrder
     */
    public function setTicketOrder(TicketOrder $ticketOrder): void
    {
        $this->ticketOrder = $ticketOrder;
    }

    /**
     * @return bool
     */
    public function getReducedPrice()
    {
        return $this->reducedPrice;
    }

    /**
     * @param int $reducedPrice
     */
    public function setReducedPrice(int $reducedPrice): void
    {
        $this->reducedPrice = $reducedPrice;
    }

    /**
     * @return mixed
     */
    public function getTicketPrice()
    {
        return $this->ticketPrice;
    }

    /**
     * @param int $ticketPrice
     */
    public function setTicketPrice(int $ticketPrice): void
    {
        $this->ticketPrice = $ticketPrice;
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
     * @param $firstname
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
     * @param $ticketNumber
     */
    public function setTicketNumber($ticketNumber): void
    {
        $this->ticketNumber = $ticketNumber;
    }

    /**
     * @return mixed
     */
    public function getTicketNumber()
    {
        return $this->ticketNumber;
    }
}
