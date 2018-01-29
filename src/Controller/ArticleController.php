<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 29/01/2018
 * Time: 10:44
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response('This is the homepage');
    }

    /**
     * @Route("/news/{slug}")
     */
    public function show($slug)
    {
        $comments = [
            'We shall say \'Ni\' again to you, if you do not appease us. You can\'t expect to wield supreme power just \'cause some watery tart threw a sword at you! …Are you suggesting that coconuts migrate? Well, we did do the nose.',
'Camelot! The Lady of the Lake, her arm clad in the purest shimmering samite, held aloft Excalibur from the bosom of the water, signifying by divine providence that I, Arthur, was to carry Excalibur. That is why I am your king.',
'Who\'s that then? But you are dressed as one… Well, what do you want? Oh, ow! We want a shrubbery!! Oh! Come and see the violence inherent in the system! Help, help, I\'m being repressed!'
        ];
        return $this->render('article/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'comments' => $comments,
    ]);
    }
}