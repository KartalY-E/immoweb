<?php

namespace App\DataFixtures;

use App\Entity\Property;
use App\Entity\PropertyType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PropertyTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $appartment = new PropertyType();
        $appartment->setName("appartment");
        $appartment->setSlug("appartment");
        $manager->persist($appartment);

        $house = new PropertyType();
        $house->setName("house");
        $house->setSlug("house");
        $manager->persist($house);

        $field = new PropertyType();
        $field->setName("field");
        $field->setSlug("field");
        $manager->persist($field);


        $manager->flush();
    }
}
