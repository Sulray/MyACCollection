<?php

namespace App\DataFixtures;

use App\Entity\Card;
use App\Repository\CardRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Village;
use App\Repository\VillageRepository;

class AppFixtures extends Fixture
{
    /**
     * Generates initialization data for films : [title, year]
     * @return \\Generator
     */



    /**
     * Generates initialization data for film recommendations:
     *  [film_title, film_year, recommendation]
     * @return \\Generator
     */
    private static function villagesDataGenerator()
    {
        yield ["Village of Martin","Nice"];
        yield ["Village of Sarah","Nice"];
        yield ["Village of Filip","Nice"];
        yield ["Village of Arthur","Nice"];
        yield ["Village of Becky","Nice"];
    }


    private static function cardsDataGenerator()
    {
        yield ["Village of Martin","Tia", 2, "Elephant","Nice one"];
        yield ["Village of Martin","Harry", 2, "Hippo","Nice one"];
        yield ["Village of Martin","Leonardo", 1, "Tiger","Nice one"];
        yield ["Village of Sarah","Curt", 1, "Bear","Nice one"];
        yield ["Village of Sarah","Wolfgang", 3, "Wolf","Nice one"];
        yield ["Village of Sarah","Tucker", 3, "Elephant","Nice one"];
        yield ["Village of Sarah","Rocco", 4, "Hippo","Nice one"];
        yield ["Village of Sarah","Pierce", 4, "Eagle","Nice one"];
        yield ["Village of Filip","Raymond", 5, "Cat","Nice one"];
        yield ["Village of Filip","Marlo", 5, "Hamster","Nice one"];

    }

    public function load(ObjectManager $manager)
    {
        $villageRepo = $manager->getRepository(Village::class);

        foreach (self::villagesDataGenerator() as [$name,$description] ) {
            $village = new Village();
            $village->setName($name);
            $village->setDescription($description);
            $manager->persist($village);
        }
        $manager->flush();

        foreach (self::cardsDataGenerator() as [$villageName,$name, $series, $species,$description] ) {
            $village = $villageRepo->findOneBy(['name' => $villageName]);
            $card = new Card();
            $card->setName($name);
            $card->setSeries($series);
            $card->setSpecies($species);
            $card->setDescription($description);
            $village->addCard($card);
            $manager->persist($card);
        }
        $manager->flush();



    }
}

