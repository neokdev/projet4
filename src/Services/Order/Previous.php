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
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * Previous constructor.
     * @param UrlGeneratorInterface $urlGenerator
     * @param SessionInterface      $session
     */
    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        SessionInterface $session
    ) {
        $this->session = $session;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @return RedirectResponse
     */
    public function previous()
    {
        $this->session->set('step', $this->session->get('step')-1);

        return RedirectResponse::create(
            $this->urlGenerator->generate('app_order')
        )->send();
    }
}
