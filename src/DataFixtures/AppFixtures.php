<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Member;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    protected $faker;

    public function __toString(): string
    {
        return Factory::class;
    }


    public function load(ObjectManager $manager,): void

    {

        $this->faker = Factory::create();
        // $product = new Product();
        // $manager->persist($product);

        $category = new Category();
        $category->setCategoryName("Jeu de dés");
        $manager->persist($category);
        $manager->flush($category);
        $category = new Category();
        $category->setCategoryName("Jeu mental");
        $manager->persist($category);
        $manager->flush($category);
        $category = new Category();
        $category->setCategoryName("Jouet");
        $manager->persist($category);
        $manager->flush($category);
        $category = new Category();
        $category->setCategoryName("Jeu de connaissance");
        $manager->persist($category);
        $manager->flush($category);
        $category = new Category();
        $category->setCategoryName("Jeu d’ambiance");
        $manager->persist($category);
        $manager->flush($category);
        $category = new Category();
        $category->setCategoryName("Jeu d’adresse");
        $manager->persist($category);
        $manager->flush($category);
        $category = new Category();
        $category->setCategoryName("Jeu créatif");
        $manager->persist($category);
        $manager->flush($category);
        $category = new Category();
        $category->setCategoryName("Jeu de stratégie");
        $manager->persist($category);
        $manager->flush($category);
        $category = new Category();
        $category->setCategoryName("Jeu de hasard");
        $manager->persist($category);
        $manager->flush($category);
        $category = new Category();
        $category->setCategoryName("Jeu de cartes");
        $manager->persist($category);
        $manager->flush($category);
        $category = new Category();
        $category->setCategoryName("Jeu éducatif");
        $manager->persist($category);
        $manager->flush($category);
        $category = new Category();
        $category->setCategoryName("Jeu de plateau");
        $manager->persist($category);
        $manager->flush($category);


// Création de 50 adhérants, sans relation avec une famille.
        for ($i = 0; $i < 50; $i++) {

            $member = new Member();
            $member->setCity($this->faker->city);
            $member->setFirstName($this->faker->firstName);
            $member->setLastName($this->faker->lastName);
            $member->setBirthday($this->faker->dateTimeThisCentury);
            $member->setEmail($this->faker->email);
            $member->setAddress($this->faker->address);
            $member->setPhone($this->faker->phoneNumber);
            $member->setZipCode($this->faker->numberBetween(10000, 99999));
            $member->setCountry($this->faker->country);

            $manager->persist($member);
            $manager->flush($member);
        }


    }
}
