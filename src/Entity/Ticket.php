<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 15/03/2018
 * Time: 12:26
 */
namespace App\Entity;

use DateTime;
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
     * @return TicketOrder|null
     */
    public function getTicketOrder(): ?TicketOrder
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
     * @return bool|null
     */
    public function getReducedPrice(): ?bool
    {
        return $this->reducedPrice;
    }

    /**
     * @param bool $reducedPrice
     */
    public function setReducedPrice(bool $reducedPrice): void
    {
        $this->reducedPrice = $reducedPrice;
    }

    /**
     * @return int|null
     */
    public function getTicketPrice(): ?int
    {
        return $this->ticketPrice;
    }

    /**
     * @param int $ticketPrice
     */
    public function setTicketPrice($ticketPrice): void
    {
        $this->ticketPrice = $ticketPrice;
    }

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @return null|string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @return null|string
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @return DateTime|null
     */
    public function getBirthdate(): ?DateTime
    {
        return $this->birthdate;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @param string $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    /**
     * @param DateTime $birthdate
     */
    public function setBirthdate($birthdate): void
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @param string $ticketNumber
     */
    public function setTicketNumber($ticketNumber): void
    {
        $this->ticketNumber = $ticketNumber;
    }

    /**
     * @return null|string
     */
    public function getTicketNumber(): ?string
    {
        return $this->ticketNumber;
    }
}
