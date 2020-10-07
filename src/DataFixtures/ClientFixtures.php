<?php

namespace App\DataFixtures;

use Faker;
use DateInterval;
use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class ClientFixtures extends Fixture
{
    
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for($i=1; $i<=15; $i++){
            $client = new Client();
            $client->setNom($faker->name);
            $client->setDateArrivee(new \DateTime("2020-" . rand(1, 12) . "-" . rand(1, 29)));
            $client->setDateDepart(new \DateTime("2020-" . rand(1, 12) . "-" . rand(1, 29)));
            $manager->persist($client);
        } 
        $manager->flush();
    }
   
}
