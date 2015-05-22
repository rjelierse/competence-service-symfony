<?php

namespace Sparse\AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AppController extends Controller
{
    /**
     * Render the application front-page.
     * 
     * @return Response
     * 
     * @Config\Route("/", name="home", methods={"GET"}, defaults={"_format": "html"})
     */
    public function indexAction()
    {
        return $this
            ->render('AppBundle::index.html.twig')
            ->setPublic();
    }
}
