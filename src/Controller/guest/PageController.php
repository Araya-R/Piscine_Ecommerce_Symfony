<?php

namespace App\Controller\guest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PageController extends AbstractController
{

    #[Route("/", name: "home")]
    public function DisplayHome()
    {
        return $this->render('guest/home.html.twig');
    }
}
