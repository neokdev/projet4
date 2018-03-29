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
 * Class Ticket
 * @ORM\Entity
 */
class Ticket
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var bool
     */
    private $reducedPrice;
    /**
     * @var string
     */
    private $lastname;
    /**
     * @var string
     */
    private $firstname;
    /**
     * @var string
     */
    private $country;
    /**
     * @var datetime
     */
    private $birthdate;
    /**
     * @var int
     */
    private $ticketPrice;
    /**
     * @var TicketOrder
     */
    private $ticketOrder;
    /**
     * @var string
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
