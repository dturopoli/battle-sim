<?php

namespace App\DataFixtures;

use App\Entity\UnitType;
use App\Model\UnitTypes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UnitTypeFixtures extends Fixture
{
    public const INFANTRY = 'infantry';
    public const CAVALRY = 'cavalry';
    public const ARTILLERY = 'artillery';

    public function load(ObjectManager $manager): void
    {
        $infantry = new UnitType();
        $infantry->setName(UnitTypes::INFANTRY);
        $manager->persist($infantry);

        $this->addReference(self::INFANTRY, $infantry);

        $cavalry = new UnitType();
        $cavalry->setName(UnitTypes::CAVALRY);
        $manager->persist($cavalry);

        $this->addReference(self::CAVALRY, $cavalry);

        $artillery = new UnitType();
        $artillery->setName(UnitTypes::ARTILLERY);
        $manager->persist($artillery);

        $this->addReference(self::ARTILLERY, $artillery);

        $manager->flush();
    }
}
