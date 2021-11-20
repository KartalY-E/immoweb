<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdminController extends AbstractController
{

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/properties', name: 'admin_property_index')]
    public function index(PropertyRepository $propertyRepository): Response
    {
        return $this->render('admin/property/index.html.twig', [
            'properties' => $propertyRepository->findAll()
        ]);
    }
}
