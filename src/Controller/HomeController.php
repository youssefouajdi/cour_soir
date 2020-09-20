<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     *
     * @Route("/", name="app_home" , methods={"GET"})
     */
    public function index()
    {
        return $this->render('education/index.html.twig');
    }
}
