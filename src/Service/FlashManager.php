<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 13/02/2018
 * Time: 23:38
 */

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Translation\TranslatorInterface;

class FlashManager
{
    /**
     * @var TranslatorInterface
     */
    private $translator;
    /**
     * @var Session
     */
    private $session;

    public function __construct(
        SessionInterface $session,
        TranslatorInterface $translator)
    {
        $this->translator = $translator;
        $this->session = $session;
    }
    public function init()
    {
        $this->session = new Session();
        $this->session->start();
    }

    public function add(string $type, string $id, array $params)
    {
        $message = $this->translator->trans($id, $params);
        $this->session->getFlashBag()->add($type, $message);
    }
}