<?php

namespace App\DataFixtures;

use App\Entity\Card;
use App\Entity\Gallery;
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

    private static function galleriesDataGenerator()
    {
        yield ["Exposition of my favorite characters",true,["Tia"],"Martin"];
        yield ["Exposition of my favorite characters",true,["Leonardo"],"Sarah"];
        yield ["Exposition of my favorite characters",true,["Curt","Tucker"],"Filip"];
        yield ["Exposition of my favorite characters",true,["Rocco"],"Arthur"];
        yield ["Exposition of my favorite characters",true,["Marlo"],"Becky"];
    }

    private static function cardsDataGenerator()
    {
        yield ["Village of Martin","Tia", 2, "Elephant",["Female","Normal"]];
        yield ["Village of Martin","Harry", 2, "Hippo",["Male","Cranky"]];
        yield ["Village of Sarah","Leonardo", 1, "Tiger",["Male","Jock"]];
        yield ["Village of Filip","Curt", 1, "Bear",["Male","Cranky"]];
        yield ["Village of Filip","Wolfgang", 3, "Wolf",["Male","Cranky"]];
        yield ["Village of Filip","Tucker", 3, "Elephant",["Male","Lazy"]];
        yield ["Village of Arthur","Rocco", 4, "Hippo",["Male","Cranky"]];
        yield ["Village of Arthur","Pierce", 4, "Eagle",["Male","Jock"]];
        yield ["Village of Becky","Raymond", 5, "Cat",["Male","Smug"]];
        yield ["Village of Becky","Marlo", 5, "Hamster",["Male","Cranky"]];

    }

    public function load(ObjectManager $manager)
    {
        $memberRepo = $manager->getRepository(Member::class);
        $villageRepo = $manager->getRepository(Village::class);
        $personalityRepo = $manager->getRepository(Personality::class);
        $cardRepo = $manager->getRepository(Card::class);


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
            $manager->persist($village);

            foreach ($personalities as $personalityName) {
                $personality = $personalityRepo->findOneBy(['name'=>$personalityName]);
                $personality->addCard($card);
                $card->addPersonality($personality);
                $manager->persist($personality);
                $manager->persist($card);
            }

        }
        $manager->flush();



        foreach (self::galleriesDataGenerator() as [$description,$published,$cards,$memberName] ) {
            $member = $memberRepo->findOneBy(['name' => $memberName]);
            $gallery = new Gallery();
            $gallery->setDescription($description);
            $gallery->setPublished($published);
            $gallery->setMember($member);

            foreach ($cards as $cardName) {
                $card = $cardRepo->findOneBy(['name'=>$cardName]);
                $card->addGallery($gallery);
                $gallery->addCard($card);
                $manager->persist($card);
                $manager->persist($gallery);
            }

        }
        $manager->flush();



    }
}

