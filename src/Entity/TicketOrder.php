<?php

namespace App\Entity;

use DateTime;
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
    public function getTicketCollection(): ?Collection
    {
        return $this->ticketCollection;
    }

    /**
     * @param string $orderNumber
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * @return DateTime|null
     */
    public function getOrderDate():? DateTime
    {
        return $this->orderDate;
    }

    /**
     * @param DateTime $orderDate
     */
    public function setOrderDate(DateTime $orderDate)
    {
        $this->orderDate = $orderDate;
    }

    /**
     * @return null|string
     */
    public function getMail(): ?string
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @param bool $duration
     */
    public function setDuration(bool $duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return int|null
     */
    public function getOrderPrice(): ?int
    {
        return $this->orderPrice;
    }

    /**
     * @param int $orderPrice
     */
    public function setOrderPrice($orderPrice)
    {
        $this->orderPrice = $orderPrice;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return DateTime|null
     */
    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    /**
     * @return bool|null
     */
    public function getDuration(): ?bool
    {
        return $this->duration;
    }

    /**
     * @return null|string
     */
    public function getOrderNumber(): ?string
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
