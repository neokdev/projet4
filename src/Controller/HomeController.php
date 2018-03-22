<?php
/**
 * Created by PhpStorm.
 * Ticket: Neok
 * Date: 29/01/2018
 * Time: 21:00
 */

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomeController
 */
class HomeController extends AbstractController
{
    /**
     * @Route(
     *     "/",
     *     name="app_homepage"
     * )
     *
     * @return Response
     */
    public function homepage()
    {
        return $this->render('homepage.html.twig');
    }

    /**
     * @Route(
     *     "/fr",
     *     name="app_fr"
     *     )
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function langFr(Request $request)
    {
        $request->getSession()->set('_locale', "fr");

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route(
     *     "/en",
     *     name="app_en"
     *     )
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function langEn(Request $request)
    {
        $request->getSession()->set('_locale', "en");

        return $this->redirect($request->headers->get('referer'));
    }
}
