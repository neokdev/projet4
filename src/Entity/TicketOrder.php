<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 15/03/2018
 * Time: 12:26
 */
namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TicketOrder
 * @ORM\Entity
 */
class TicketOrder
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var datetime
     */
    private $date;
    /**
     * @var datetime
     */
    private $orderDate;
    /**
     * @var bool
     */
    private $duration;
    /**
     * @var ArrayCollection
     */
    private $ticketCollection;
    /**
     * @var string
     */
    private $mail;
    /**
     * @var string
     */
    private $orderPrice;
    /**
     * @var string
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
    public function setOrderNumber($orderNumber): void
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
    public function setOrderDate(DateTime $orderDate): void
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
    public function setMail($mail): void
    {
        $this->mail = $mail;
    }
    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }
    /**
     * @param bool $duration
     */
    public function setDuration(bool $duration): void
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
    public function setOrderPrice($orderPrice): void
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
