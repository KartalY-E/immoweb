<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(PropertyRepository $propertyRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'user' => $this->getUser(),
            'properties' => $propertyRepository->randomProperty(4)  
        ]);
    }
}
