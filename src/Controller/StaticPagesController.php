<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StaticPagesController extends AbstractController
{
    /**
     * @Route("/a-propos", name="a-propos")
     */
    public function about()
    {
        return $this->render('static_pages/index.html.twig', [
            'controller_name' => 'StaticPagesController',
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('static_pages/index.html.twig', [
            'controller_name' => 'StaticPagesController',
        ]); 
    }

    /**
     * @Route("/mentions-legales", name="mentions-legales")
     */
    public function legalTerms()
    {
        return $this->render('static_pages/index.html.twig', [
            'controller_name' => 'StaticPagesController',
        ]); 
    }
}
