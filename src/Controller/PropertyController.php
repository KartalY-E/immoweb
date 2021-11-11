<?php

namespace App\Controller;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Ramsey\Uuid\Uuid;
use App\Services\FileUploader;

class PropertyController extends AbstractController
{
    #[Route('/', name: 'property_index', methods: ['GET'])]
    public function index(PropertyRepository $propertyRepository): Response
    {
        return $this->render('property/index.html.twig', [
            'properties' => $propertyRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('property/new', name: 'property_new', methods: ['GET', 'POST'])]
    public function new(Request $request,FileUploader $fileUploader): Response
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            
            // Setting the user
            $property->setUser($this->getUser());

            // unique id & set as Slug,Images folder
            $uid = Uuid::uuid4();
            $property->setSlug($uid);
            
            //upload the images
            $fileUploader->uploadImageProgerty($property,$form['upload']->getData());

            $entityManager->persist($property);
            $entityManager->flush();

            return $this->redirectToRoute('property_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('property/new.html.twig', [
            'property' => $property,
            'form' => $form,
        ]);
    }

    #[Route('property/{slug}', name: 'property_show', methods: ['GET'])]
    public function show(Property $property): Response
    {
        return $this->render('property/show.html.twig', [
            'property' => $property,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('property/{slug}/edit', name: 'property_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Property $property,FileUploader $fileUploader): Response
    {
        if ($property->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        $form = $this->createForm(PropertyType::class, $property, ['property_id' => $property->getId()]);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            //upload the images
            $fileUploader->uploadImageProgerty($property,$form['upload']->getData());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('property_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('property/edit.html.twig', [
            'property' => $property,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('property/{slug}', name: 'property_delete', methods: ['POST'])]
    public function delete(Request $request, Property $property): Response
    {
        if ($property->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($property);
            $entityManager->flush();
        }

        return $this->redirectToRoute('property_index', [], Response::HTTP_SEE_OTHER);
    }
}
