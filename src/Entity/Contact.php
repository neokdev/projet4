<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 15/03/2018
 * Time: 12:26
 */
namespace App\Entity;

/**
 * Class Contact
 */
class Contact
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $messageType;
    /**
     * @var string
     */
    private $subject;
    /**
     * @var string
     */
    private $messageText;
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }
    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    /**
     * @return null|string
     */
    public function getMessageType(): ?string
    {
        return $this->messageType;
    }
    /**
     * @param string $messageType
     */
    public function setMessageType(string $messageType): void
    {
        $this->messageType = $messageType;
    }
    /**
     * @return null|string
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }
    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }
    /**
     * @return null|string
     */
    public function getMessageText(): ?string
    {
        return $this->messageText;
    }
    /**
     * @param string $messageText
     */
    public function setMessageText(string $messageText): void
    {
        $this->messageText = $messageText;
    }
}
