<?php

namespace App\Controller;

use App\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class UserController extends AbstractController
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/profile', name: 'profile')]
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $userProperties = $this->security->getUser()->getProperties();
        $query = $userProperties;

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            8 /*limit per page*/
        );

        $response =  $this->render('user/profile.html.twig', [
            'properties' => $pagination
        ]);
        $response->setSharedMaxAge(3600);
        return $response;
    }
}
