<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AdmPageController extends AbstractController
{

    #[Route("admin", name: "admin-home")]
    public function DisplayAdminHome()
    {
        return $this->render('admin/home.html.twig');
    }
}
