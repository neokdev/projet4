<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 19/03/2018
 * Time: 14:35
 */

namespace App\Services\Order;

use App\Services\DateHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

/**
 * Class Checkout
 */
class Checkout extends AbstractController
{
    /**
     * @var DateHelper
     */
    private $helper;
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * Checkout constructor.
     * @param Environment           $twig
     * @param DateHelper            $helper
     * @param SessionInterface      $session
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        Environment $twig,
        DateHelper $helper,
        SessionInterface $session,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->helper       = $helper;
        $this->session      = $session;
        $this->twig         = $twig;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param Request $request
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return string|RedirectResponse
     */
    public function checkout(Request $request)
    {
        $locale = $request->getLocale() === 'fr' ? 'fr_FR.UTF8' : $request->getLocale();
        setlocale(LC_TIME, $locale);
        $date = strftime("%A %e %B %Y", $this->helper->getSelectedDate()->getTimestamp());

        return $this->twig->render('Order/_checkout.html.twig', [
            'date'      => $date,
            'cardTitle' => "cardTitleConfirm",
            'order'     => $this->session->get('order'),
            'tickets'   => $this->session->get('tickets'),
        ]);
    }
}
