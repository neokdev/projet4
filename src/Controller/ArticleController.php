<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 29/01/2018
 * Time: 10:44
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ArticleController
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
        return new Response(sprintf(
            'Future page the article: %s',
            $slug));
    }
}