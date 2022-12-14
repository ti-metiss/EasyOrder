<?php

namespace App\DataFixtures;

use App\Entity\Panier;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture implements FixtureGroupInterface
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $fake = Factory::create('fr_FR');
        $admin = new User();
        //    $panierAdmin = new Panier();
        //   $panierAdmin->setIdUser($admin->getId());
        //  $manager->persist($panierAdmin);
        //  $admin->addPanier($panierAdmin);
        $admin->setEmail("admin@gmail.com");
        $admin->setPassword($this->hasher->hashPassword($admin, 'test'));
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setNom("Admin");
        $admin->setPrenom("Admin");
        $admin->setAdresse("5 rue du moulin");
        $admin->setVille("Paris");
        $admin->setPays("France");
        $admin->setDateNaissance($fake->dateTimeBetween('-90 year', '-18 years'));
        $admin->setCodePostal("78710");
        $manager->persist($admin);

        $user = new User();
        //  $panierUser = new Panier();
        //  $panierUser->setIdUser($user->getId());
        //  $manager->persist($panierUser);
        //  $user->addPanier($panierUser);
        $user->setEmail("test@gmail.com");
        $user->setPassword($this->hasher->hashPassword($user, 'test'));
        $user->setRoles(["ROLE_USER"]);
        $user->setNom("test");
        $user->setPrenom("test");
        $user->setAdresse($fake->address);
        $user->setVille("Marseille");
        $user->setPays("France");
        $user->setCodePostal("78710");
        $user->setDateNaissance($fake->dateTimeBetween('-90 year', '-18 years'));
        $manager->persist($user);

        for ($i = 0; $i < 100; $i++) {
            $user = new User();
            /*    $panierUser = new Panier();
            // $panierUser->setIdUser($user->getId());
            $manager->persist($panierUser);
            $user->addPanier($panierUser);
        */
            $user->setEmail($fake->email);
            $user->setPassword($this->hasher->hashPassword($user, 'test'));
            $user->setNom($fake->lastName);
            $user->setPrenom($fake->firstName);
            $user->setAdresse($fake->address);
            $user->setVille($fake->city);
            $user->setPays("France");
            $user->setCodePostal($fake->postcode());
            $user->setDateNaissance($fake->dateTimeBetween('-90 year', '-18 years'));
            $manager->persist($user);
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ["group1", 'User'];
    }
}
