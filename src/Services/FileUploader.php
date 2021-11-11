<?php

namespace App\Services;

use App\Entity\Image;
use App\Entity\Property;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Doctrine\ORM\EntityManagerInterface;

class FileUploader{

    private $destination;
    private $params;

    public function __construct(ParameterBagInterface $params,EntityManagerInterface $entityManager)
    {
        $this->params = $params;
        $this->entityManager = $entityManager;
        // Where to upload files 
        $this->destination = $this->params->get('kernel.project_dir').'/public/uploads/';
    }

    // upload images to public/uploads/ 
    public function uploadImageProgerty(Property $property,$formUploads)
    {
        // $entityManager = $this->container->getDoctrine()->getManager();

        // Loop throught all images
        foreach ($formUploads as $file) {

            // Get original filename and create new Filename so they are all unique
            $originalFilename = substr($file->getClientOriginalName(), 0, strrpos($file->getClientOriginalName(), '.'));
            $newFilename = $originalFilename .'-'.uniqid().'.'.$file->guessExtension();

            $file->move(
                $this->destination,
                $newFilename
            );
            // New image with new filename ,property
            $image = new Image();
            $image->setFilename($newFilename);
            $image->setProperty($property);
            $image->setOriginalFilename($originalFilename);
            $this->entityManager->persist($image);
        }
    }
}

