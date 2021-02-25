<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StaticPagesController extends AbstractController
{
    /**
     * @Route("/a-propos", name="about")
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
     * @Route("/mentions-legales", name="legal-terms")
     */
    public function legalTerms()
    {
        return $this->render('static_pages/legal_terms.html.twig'); 
    }
}
