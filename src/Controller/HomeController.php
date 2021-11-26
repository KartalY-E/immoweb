<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(PropertyRepository $propertyRepository): Response
    {
        $response =  $this->render('home/index.html.twig', [
            'user' => $this->getUser(),
            'properties' => $propertyRepository->randomProperty(4)
        ]);

        // sets the shared max age - which also marks the response as public
        $response->setSharedMaxAge(3600);
        return $response;
    }
}
