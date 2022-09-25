<?php

namespace App\DataFixtures;

use App\Entity\Unit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UnitFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Infantry
        $spearman = new Unit();
        $spearman->setName('Spearman')
            ->setAttack(1)
            ->setDefense(5)
            ->setUnitType($this->getReference(UnitTypeFixtures::INFANTRY));

        $manager->persist($spearman);

        $samurai = new Unit();
        $samurai->setName('Samurai')
            ->setAttack(3)
            ->setDefense(10)
            ->setUnitType($this->getReference(UnitTypeFixtures::INFANTRY));

        $manager->persist($samurai);

        // Cavalry
        $wingedHussar = new Unit();
        $wingedHussar->setName('Winged Hussar')
            ->setAttack(7)
            ->setDefense(15)
            ->setUnitType($this->getReference(UnitTypeFixtures::CAVALRY));

        $manager->persist($wingedHussar);

        $knight = new Unit();
        $knight->setName('Knight')
            ->setAttack(5)
            ->setDefense(12)
            ->setUnitType($this->getReference(UnitTypeFixtures::CAVALRY));

        $manager->persist($knight);

        // Artillery
        $catapult = new Unit();
        $catapult->setName('Catapult')
            ->setAttack(15)
            ->setDefense(20)
            ->setUnitType($this->getReference(UnitTypeFixtures::ARTILLERY));

        $manager->persist($catapult);

        $ballista = new Unit();
        $ballista->setName('Ballista')
            ->setAttack(20)
            ->setDefense(15)
            ->setUnitType($this->getReference(UnitTypeFixtures::ARTILLERY));


        $manager->persist($ballista);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [UnitTypeFixtures::class];
    }
}
