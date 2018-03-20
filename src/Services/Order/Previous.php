<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 19/03/2018
 * Time: 15:15
 */

namespace App\Services\Order;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class Previous
 */
class Previous
{
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * Previous constructor.
     * @param RouterInterface  $router
     * @param SessionInterface $session
     */
    public function __construct(
        RouterInterface $router,
        SessionInterface $session
    ) {
        $this->session = $session;
        $this->router = $router;
    }

    /**
     *
     */
    public function previous(): void
    {
        $this->session->set('step', $this->session->get('step')-1);
        RedirectResponse::create(
            $this->router->generate('app_order')
        )->send();
    }
}
