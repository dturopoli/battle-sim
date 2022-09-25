<?php

namespace App\Tests\Service\Factory;

use App\Contract\Service\ArmyFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ArmyFactoryTest extends KernelTestCase
{
    public function testCreate()
    {
        self::bootKernel();
        $container = static::getContainer();

        /** @var ArmyFactoryInterface $armyBuilder */
        $armyFactory = $container->get(ArmyFactoryInterface::class);

        $army = $armyFactory->create('army_name', 10);

        $this->assertEquals('army_name', $army->getName());
        $this->assertEquals(10, $army->getNumberOfTroops());
    }
}
