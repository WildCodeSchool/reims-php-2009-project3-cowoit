<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $contributor = new User();

        $contributor->setEmail('cowoit@cowoit.com');

        $contributor->setRoles(['ROLE_USER']);

        $contributor->setFirstname('Test');

        $contributor->setLastname('Cowoit');

        $contributor->setPassword($this->passwordEncoder->encodePassword($contributor, 'cowoit'));

        $manager->persist($contributor);

        $manager->flush();
    }
}
