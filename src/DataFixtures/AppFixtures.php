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
    private static function cardsDataGenerator()
    {
        yield ["Tia", 2, "Elephant"];
        yield ["Harry", 2, "Hippo"];
        yield ["Leonardo", 1, "Tiger"];
        yield ["Curt", 1, "Bear"];
        yield ["Wolfgang", 3, "Wolf"];
        yield ["Tucker", 3, "Elephant"];
        yield ["Rocco", 4, "Hippo"];
        yield ["Pierce", 4, "Eagle"];
        yield ["Raymond", 5, "Cat"];
        yield ["Marlo", 5, "Hamster"];

    }

    public function load(ObjectManager $manager)
    {
        $filmRepo = $manager->getRepository(Card::class);

        foreach (self::cardsDataGenerator() as [$name, $serie, $specie] ) {
            $carte = new Card();
            $carte->setName($name);
            $carte->setSerie($serie);
            $carte->setSpecie($specie);
            $manager->persist($carte);
        }
        $manager->flush();



    }
}

