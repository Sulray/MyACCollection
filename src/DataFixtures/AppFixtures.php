<?php

namespace App\DataFixtures;

use App\Entity\Card;
use App\Entity\Member;
use App\Entity\Personality;
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

    private static function personalitiesDataGenerator()
    {
        yield ["Male",null];
        yield ["Female",null];
        yield ["Jock","Male"];
        yield ["Cranky","Male"];
        yield ["Lazy","Male"];
        yield ["Smug","Male"];
        yield ["Peppy","Female"];
        yield ["Big sister","Female"];
        yield ["Normal","Female"];
        yield ["Snooty","Female"];
    }


    private static function villagesDataGenerator()
    {
        yield ["Village of Martin","Martin"];
        yield ["Village of Sarah","Sarah"];
        yield ["Village of Filip","Filip"];
        yield ["Village of Arthur","Arthur"];
        yield ["Village of Becky","Becky"];
    }

    private static function membersDataGenerator()
    {
        yield ["Martin"];
        yield ["Sarah"];
        yield ["Filip"];
        yield ["Arthur"];
        yield ["Becky"];
    }

    private static function cardsDataGenerator()
    {
        yield ["Village of Martin","Tia", 2, "Elephant",["Female","Normal"]];
        yield ["Village of Martin","Harry", 2, "Hippo",["Male","Cranky"]];
        yield ["Village of Martin","Leonardo", 1, "Tiger",["Male","Jock"]];
        yield ["Village of Sarah","Curt", 1, "Bear",["Male","Cranky"]];
        yield ["Village of Sarah","Wolfgang", 3, "Wolf",["Male","Cranky"]];
        yield ["Village of Sarah","Tucker", 3, "Elephant",["Male","Lazy"]];
        yield ["Village of Sarah","Rocco", 4, "Hippo",["Male","Cranky"]];
        yield ["Village of Sarah","Pierce", 4, "Eagle",["Male","Jock"]];
        yield ["Village of Filip","Raymond", 5, "Cat",["Male","Smug"]];
        yield ["Village of Filip","Marlo", 5, "Hamster",["Male","Cranky"]];

    }

    public function load(ObjectManager $manager)
    {
        $memberRepo = $manager->getRepository(Member::class);
        $villageRepo = $manager->getRepository(Village::class);
        $personalityRepo = $manager->getRepository(Personality::class);


        foreach (self::personalitiesDataGenerator() as [$name,$parentName] ) {
            $personality = new Personality();
            $personality->setName($name);
            if ($parentName !== null) {
                $parent = $personalityRepo->findOneBy(['name'=>$parentName]);
                $personality->setParent($parent);
            }
            $manager->persist($personality);
            $manager->flush();
        }

        foreach (self::membersDataGenerator() as [$name] ) {
            $member = new Member();
            $member->setName($name);
            $manager->persist($member);
        }
        $manager->flush();


        foreach (self::villagesDataGenerator() as [$name,$memberName] ) {
            $member = $memberRepo->findOneBy(['name' => $memberName]);
            print($memberName);
            print($member);
            $village = new Village();
            $village->setName($name);
            $member->addVillage($village);
            $manager->persist($village);
        }
        $manager->flush();



        foreach (self::cardsDataGenerator() as [$villageName,$name, $series, $species, $personalities] ) {
            $village = $villageRepo->findOneBy(['name' => $villageName]);
            $card = new Card();
            $card->setName($name);
            $card->setSeries($series);
            $card->setSpecies($species);
            $village->addCard($card);
            foreach ($personalities as $personalityName) {
                $personality = $personalityRepo->findOneBy(['name'=>$personalityName]);
                $personality->addCard($card);
                $card->addPersonality($personality);
                $manager->persist($personality);
                $manager->persist($card);
            }
            $manager->persist($village);
        }
        $manager->flush();



    }
}

