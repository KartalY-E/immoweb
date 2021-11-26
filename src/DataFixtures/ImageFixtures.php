<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Repository\PropertyRepository;
use App\Repository\UserRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ImageFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(UserRepository $userRepository, PropertyRepository $propertyRepository)
    {
        $this->userRepository = $userRepository;
        $this->propertyRepository = $propertyRepository;
    }

    public function load(ObjectManager $manager): void
    {
        // Lowest id of properties by UserAndPropertyFixtures
        $first_id = $this->propertyRepository->findFirstId()[1];

        // Adding images to the first Property
        $image = new Image();
        $image->setOriginalFilename('house-1-1');
        $image->setFilename('house1-1-61a0f0047bb7c.jpg');
        $image->setProperty($this->propertyRepository->find($first_id));
        $manager->persist($image);
        $image = new Image();
        $image->setOriginalFilename('house-1-2');
        $image->setFilename('house1-2-61a0f0049768f.jpg');
        $image->setProperty($this->propertyRepository->find($first_id));
        $manager->persist($image);
        $image = new Image();
        $image->setOriginalFilename('house-1-3');
        $image->setFilename('house1-3-61a0f00497d93.jpg');
        $image->setProperty($this->propertyRepository->find($first_id));
        $manager->persist($image);

        // Adding images to the second Property
        $image = new Image();
        $image->setOriginalFilename('house2-1');
        $image->setFilename('house2-1-61a0f0899a01e.jpg');
        $image->setProperty($this->propertyRepository->find($first_id + 1));
        $manager->persist($image);
        $image = new Image();
        $image->setOriginalFilename('house2-2');
        $image->setFilename('house2-2-61a0f0899ba0d.jpg');
        $image->setProperty($this->propertyRepository->find($first_id + 1));
        $manager->persist($image);
        $image = new Image();
        $image->setOriginalFilename('house2-3');
        $image->setFilename('house2-3-61a0f089a2129.jpg');
        $image->setProperty($this->propertyRepository->find($first_id + 1));
        $manager->persist($image);

        // Adding images to the third Property
        $image = new Image();
        $image->setOriginalFilename('house3-1');
        $image->setFilename('house3-1-61a0f151473f1.jpg');
        $image->setProperty($this->propertyRepository->find($first_id + 2));
        $manager->persist($image);
        $image = new Image();
        $image->setOriginalFilename('house3-2');
        $image->setFilename('house3-2-61a0f15148ebd.jpg');
        $image->setProperty($this->propertyRepository->find($first_id + 2));
        $manager->persist($image);
        $image = new Image();
        $image->setOriginalFilename('house3-3');
        $image->setFilename('house3-3-61a0f151496a0.jpg');
        $image->setProperty($this->propertyRepository->find($first_id + 2));
        $manager->persist($image);

        // Adding images to the fourth Property
        $image = new Image();
        $image->setOriginalFilename('house4-1');
        $image->setFilename('house4-1-61a0f16d942eb.jpg');
        $image->setProperty($this->propertyRepository->find($first_id + 3));
        $manager->persist($image);
        $image = new Image();
        $image->setOriginalFilename('house4-2');
        $image->setFilename('house4-2-61a0f16d9b96c.jpg');
        $image->setProperty($this->propertyRepository->find($first_id + 3));
        $manager->persist($image);
        $image = new Image();
        $image->setOriginalFilename('house4-3');
        $image->setFilename('house4-3-61a0f16d9e222.jpg');
        $image->setProperty($this->propertyRepository->find($first_id + 3));
        $manager->persist($image);

        // Adding images to the fifth Property
        $image = new Image();
        $image->setOriginalFilename('house5-1');
        $image->setFilename('house5-1-61a0f27ec8578.jpg');
        $image->setProperty($this->propertyRepository->find($first_id + 4));
        $manager->persist($image);
        $image = new Image();
        $image->setOriginalFilename('house5-2');
        $image->setFilename('house5-2-61a0f27eca05c.jpg');
        $image->setProperty($this->propertyRepository->find($first_id + 4));
        $manager->persist($image);
        $image = new Image();
        $image->setOriginalFilename('house5-3');
        $image->setFilename('house5-3-61a0f27ed0140.jpg');
        $image->setProperty($this->propertyRepository->find($first_id + 4));
        $manager->persist($image);

        // Adding images to the sixth Property
        $image = new Image();
        $image->setOriginalFilename('house6-1');
        $image->setFilename('house6-1-61a0f37c331ed.jpg');
        $image->setProperty($this->propertyRepository->find($first_id + 5));
        $manager->persist($image);
        $image = new Image();
        $image->setOriginalFilename('house6-2');
        $image->setFilename('house6-2-61a0f37c3b538.jpg');
        $image->setProperty($this->propertyRepository->find($first_id + 5));
        $manager->persist($image);
        $image = new Image();
        $image->setOriginalFilename('house6-3');
        $image->setFilename('house6-3-61a0f37c3be10.jpg');
        $image->setProperty($this->propertyRepository->find($first_id + 5));
        $manager->persist($image);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PropertyTypeFixtures::class,
            UserAndPropertyFixtures::class
        ];
    }
}
