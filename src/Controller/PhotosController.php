<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PhotosController extends AbstractController
{
    /**
     * @Route("/photos", name="photos_display_all")
     */
    public function displayAllPhotos()
    {
        return $this->render('photos/index.html.twig', [
            'controller_name' => 'PhotosController',
        ]);
    }

    /**
     * @Route("/photos/serie/{slug}", name="photos_series")
     */
    public function displayPhotoSeries()
    {
        return $this->render('photos/index.html.twig', [
            'controller_name' => 'photosController',
        ]);
    }

    /**
     * @Route("/photos/tag/{slug}", name="photos_tag")
     */
    public function displayPhotoTag()
    {
        return $this->render('photos/index.html.twig', [
            'controller_name' => 'photosController',
        ]);
    }

    /**
     * @Route("/photos/afficher/{slug}", name="photos_display_one")
     */
    public function displayPhoto()
    {
        return $this->render('photos/index.html.twig', [
            'controller_name' => 'photosController',
        ]);
    }
}
