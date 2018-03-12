<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketOrderRepository")
 * @ORM\Entity
 * @ORM\Table(name="ticket_order")
 */
class TicketOrder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="date")
     */
    private $orderDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $duration;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket",
     *     mappedBy="ticketOrder",
     *     cascade={"persist"}
     * )
     */
    private $ticketCollection;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     */
    private $mail;

    /**
     * @ORM\Column(type="string")
     */
    private $orderPrice;

    /**
     * @ORM\Column(type="string")
     */
    private $orderNumber;

    /**
     * TicketOrder constructor.
     */
    public function __construct()
    {
        $this->ticketCollection = new ArrayCollection();
    }

    /**
     * @return Collection|null
     */
    public function getTicketCollection(): Collection
    {
        return $this->ticketCollection;
    }

    /**
     * @param $orderNumber
     */
    public function setOrderNumber($orderNumber): void
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * @return mixed
     */
    public function getOrderDate():? int
    {
        return $this->orderDate;
    }

    /**
     * @param $orderDate
     */
    public function setOrderDate(\DateTime $orderDate): void
    {
        $this->orderDate = $orderDate;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail): void
    {
        $this->mail = $mail;
    }

    /**
     * @param mixed $date
     */
    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @return int
     */
    public function getOrderPrice()
    {
        return $this->orderPrice;
    }

    /**
     * @param $orderPrice
     */
    public function setOrderPrice($orderPrice): void
    {
        $this->orderPrice = $orderPrice;
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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return mixed
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * @param Ticket $ticket
     */
    public function addTicket(Ticket $ticket)
    {
        $this->ticketCollection->add($ticket);
        $ticket->setTicketOrder($this);
    }
}
