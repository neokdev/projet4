<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 21/03/2018
 * Time: 10:17
 */

namespace App\Services;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class SessionHelper
 */
class SessionHelper
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * SessionHelper constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     *
     */
    public function clearSessionVars(): void
    {
        $this->session->remove('step');
        $this->session->remove('order');
        $this->session->remove('ticket');
        $this->session->remove('tickets');
    }
}
