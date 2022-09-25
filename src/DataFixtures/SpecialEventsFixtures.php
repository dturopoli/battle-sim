<?php

namespace App\DataFixtures;

use App\Entity\SpecialEvent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SpecialEventsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $divineIntervention = new SpecialEvent();
        $divineIntervention->setName('Divine intervention')
            ->setDescription('God of war assisted you.')
            ->setModifier(2);

        $manager->persist($divineIntervention);

        $mutiny = new SpecialEvent();
        $mutiny->setName('mutiny')
            ->setDescription('Troops refused to listen.')
            ->setModifier(0.5);

        $manager->persist($mutiny);

        $superbGeneral = new SpecialEvent();
        $superbGeneral->setName('Superb general')
            ->setDescription('Superb general joined your troops')
            ->setModifier(1.5);

        $manager->persist($superbGeneral);

        $manager->flush();
    }
}
