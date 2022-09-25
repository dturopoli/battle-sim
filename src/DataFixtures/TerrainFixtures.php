<?php

namespace App\DataFixtures;

use App\Entity\Terrain;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TerrainFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $mountains = new Terrain();
        $mountains->setName('Mountains')
            ->setDefenderModifier(1.4)
            ->setAttackerModifier(0.6);

        $manager->persist($mountains);

        $hills = new Terrain();
        $hills->setName('Hills')
            ->setDefenderModifier(1.2)
            ->setAttackerModifier(0.8);

        $manager->persist($hills);

        $plains = new Terrain();
        $plains->setName('Plains')
            ->setDefenderModifier(1)
            ->setAttackerModifier(1);

        $manager->persist($plains);

        $riverCrossing = new Terrain();
        $riverCrossing->setName('River Crossing')
            ->setDefenderModifier(1.1)
            ->setAttackerModifier(0.9);

        $manager->persist($riverCrossing);

        $manager->flush();
    }
}
