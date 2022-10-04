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
        yield ["Village of Martin"];
        yield ["Village of Sarah"];
        yield ["Village of Filip"];
        yield ["Village of Arthur"];
        yield ["Village of Becky"];
    }


    private static function cardsDataGenerator()
    {
        yield ["Village of Martin","Tia", 2, "Elephant"];
        yield ["Village of Martin","Harry", 2, "Hippo"];
        yield ["Village of Martin","Leonardo", 1, "Tiger"];
        yield ["Village of Sarah","Curt", 1, "Bear"];
        yield ["Village of Sarah","Wolfgang", 3, "Wolf"];
        yield ["Village of Sarah","Tucker", 3, "Elephant"];
        yield ["Village of Sarah","Rocco", 4, "Hippo"];
        yield ["Village of Sarah","Pierce", 4, "Eagle"];
        yield ["Village of Filip","Raymond", 5, "Cat"];
        yield ["Village of Filip","Marlo", 5, "Hamster"];

    }

    public function load(ObjectManager $manager)
    {
        $villageRepo = $manager->getRepository(Village::class);

        foreach (self::villagesDataGenerator() as [$name] ) {
            $village = new Village();
            $village->setName($name);
            $manager->persist($village);
        }
        $manager->flush();

        foreach (self::cardsDataGenerator() as [$villageName,$name, $series, $species] ) {
            $village = $villageRepo->findOneBy(['name' => $villageName]);
            $card = new Card();
            $card->setName($name);
            $card->setSeries($series);
            $card->setSpecies($species);
            $village->addCard($card);
            $manager->persist($card);
        }
        $manager->flush();



    }
}

