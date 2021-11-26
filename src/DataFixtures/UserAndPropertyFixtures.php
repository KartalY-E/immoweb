<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Property;
use Faker\Factory;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Repository\PropertyTypeRepository;
use App\Repository\UserRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserAndPropertyFixtures extends Fixture implements DependentFixtureInterface
{
    protected $faker;

    public function __construct(UserPasswordEncoderInterface $encoder, UserRepository $userRepository, PropertyTypeRepository $propertyTypeRepository)
    {
        $this->encoder = $encoder;
        $this->userRepository = $userRepository;
        $this->propertyTypeRepository = $propertyTypeRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();
        $this->manager = $manager;

        // create 20 users! Bam!
        for ($i = 0; $i < 20; $i++) {
            $user = new User();

            $user->setEmail($this->faker->email());
            $password = $this->encoder->encodePassword($user, 'password');
            $user->setPassword($password);
            $user->setRoles(['ROLE_USER']);

            $user->setFirstname($this->faker->firstname());
            $user->setLastname($this->faker->lastname());
            $user->setPhone('0485677890');

            $manager->persist($user);

            // Add a property to user
            $property = new Property();
            $property->setPrice(mt_rand(1000, 999900));
            $property->setDescription($this->faker->realText(200, 2));
            $property->setBedroom(mt_rand(0, 5));
            $property->setBathroom(mt_rand(0, 5));
            $property->setSquareMeters(mt_rand(50, 500));
            $property->setBuildYear($this->faker->dateTimeBetween($startDate = '-50 years', $endDate = 'now', $timezone = null));
            $cities = ['Antwerpen', 'Brussel', 'Leuven', 'Genk', 'Gent'];   
            $key = array_rand($cities, 1);
            $property->setCity($cities[$key]);
            $property->setStreet($this->faker->streetAddress());
            // $property->setUser($this->userRepository->randomUser());

            $property->setUser($user);
            // $property->setUser($this->propertyTypeRepository->find($this->userRepository->randomUser()));
            $property->setPropertyType($this->propertyTypeRepository->findOneByRandom());
            $property->setSlug(Uuid::uuid4());
            $manager->persist($property);
        }
        // create 2 ADMIN! Bam!
        for ($i = 0; $i < 2; $i++) {
            $user = new User();

            $user->setEmail('admin' . $i . '@gmail.com');
            $password = $this->encoder->encodePassword($user, 'password');
            $user->setPassword($password);
            $user->setRoles(['ROLE_ADMIN']);

            $user->setFirstname($this->faker->firstname());
            $user->setLastname($this->faker->lastname());
            $user->setPhone('0485677890');

            $manager->persist($user);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            PropertyTypeFixtures::class
        ];
    }
}
