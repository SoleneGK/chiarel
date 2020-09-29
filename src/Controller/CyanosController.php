<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CyanosController extends AbstractController
{
    /**
     * @Route("/cyanos", name="cyanos_display_all")
     */
    public function displayAllCyanos()
    {
        return $this->render('cyanos/index.html.twig', [
            'controller_name' => 'CyanosController',
        ]);
    }

    /**
     * @Route("/cyanos/serie/{slug}", name="cyanos_series")
     */
    public function displayCyanoSeries()
    {
        return $this->render('cyanos/index.html.twig', [
            'controller_name' => 'CyanosController',
        ]);
    }

    /**
     * @Route("/cyanos/tag/{slug}", name="cyanos_tag")
     */
    public function displayCyanoTag()
    {
        return $this->render('cyanos/index.html.twig', [
            'controller_name' => 'CyanosController',
        ]);
    }

    /**
     * @Route("/cyanos/en-vente", name="cyanos_for_sale")
     */
    public function displayCyanoForSale()
    {
        return $this->render('cyanos/index.html.twig', [
            'controller_name' => 'CyanosController',
        ]);
    }

    /**
     * @Route("/cyanos/afficher/{slug}", name="cyanos_display_one")
     */
    public function displayCyano()
    {
        return $this->render('cyanos/index.html.twig', [
            'controller_name' => 'CyanosController',
        ]);
    }
}
