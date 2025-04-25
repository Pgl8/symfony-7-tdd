<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    private UserPasswordHasherInterface $passwordHasher;
    private ParameterBagInterface $params;

    public function __construct(UserPasswordHasherInterface $passwordHasher, ParameterBagInterface $params)
    {
        $this->passwordHasher = $passwordHasher;
        $this->params = $params;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail($this->params->get('app.default_admin_email'));
        $user->setPassword($this->passwordHasher->hashPassword($user, $this->params->get('app.default_admin_password')));
        $user->setUsername($this->params->get('app.default_admin_username'));
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);
        $manager->flush();
    }
}
