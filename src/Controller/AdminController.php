<?php

namespace App\Controller;

use App\Repository\SlideRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
   
    #[Route('/admin/slides', name: 'admin_slides')]
    public function administrationSlide(SlideRepository $slideRepository): Response {

        $listeSlide = $slideRepository->findAll();

        return $this->render('admin/admin-slide.html.twig', [
            'listeSlide' => $listeSlide, 
        ]);
    }

}
