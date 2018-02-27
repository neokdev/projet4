<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     * TicketOrder constructor.
     */
    public function __construct()
    {
        $this->order_number = new ArrayCollection();
    }

    /**
     * @return Collection|null
     */
    public function getTicketCollection(): Collection
    {
        return $this->order_number;
    }

    /**
     * @param mixed $order_number
     */
    public function setOrderNumber($order_number): void
    {
        $this->order_number = $order_number;
    }

    /**
     * @return mixed
     */
    public function getOrderDate():? int
    {
        return $this->order_date;
    }

    /**
     * @param mixed $order_date
     */
    public function setOrderDate($order_date): void
    {
        $this->order_date = $order_date;
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
    public function setDate($date): void
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
     * @return mixed
     */
    public function getOrderPrice()
    {
        return $this->order_price;
    }

    /**
     * @param mixed $order_price
     */
    public function setOrderPrice($order_price): void
    {
        $this->order_price = $order_price;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="array")
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket",
     *     mappedBy="TicketOrder"
     * )
     */
    private $order_number;

    /**
     * @ORM\Column(type="date")
     */
    private $order_date;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     */
    private $mail;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @ORM\Column(type="boolean")
     */
    private $duration;

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $order_price;

    /**
     * @param Ticket $ticket
     * @return TicketOrder
     */
    public function addTicket(Ticket $ticket)
    {
        $this->order_number->add($ticket);
        $ticket->setTicketNumber($this);
    }
}
