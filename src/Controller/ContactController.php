<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 15/03/2018
 * Time: 12:26
 */

namespace App\Controller;

use App\Services\Contact\Contact;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ContactController
 */
class ContactController extends AbstractController
{
    /**
     * @Route(
     *     "/contact",
     *     name="app_contact")
     * @param Request $request
     * @param Contact $contact
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return Response
     */
    public function contact(Request $request, Contact $contact)
    {
        return new Response($contact->contact($request));
    }
}
