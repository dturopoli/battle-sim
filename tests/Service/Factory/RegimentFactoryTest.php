<?php

namespace App\Tests\Service\Factory;

use App\Contract\Service\RegimentFactoryInterface;
use App\Entity\Unit;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RegimentFactoryTest extends KernelTestCase
{
    public function testCreate()
    {
        self::bootKernel();
        $container = static::getContainer();

        /** @var RegimentFactoryInterface $regimentFactory */
        $regimentFactory = $container->get(RegimentFactoryInterface::class);

        $unit = new Unit();
        $unit->setName('unit_name')
            ->setAttack(1)
            ->setDefense(10);

        $regiment = $regimentFactory->create($unit, 10);

        $this->assertEquals($unit->getName(), $regiment->getUnit()->getName());
        $this->assertEquals($unit->getAttack(), $regiment->getUnit()->getAttack());
        $this->assertEquals($unit->getDefense(), $regiment->getUnit()->getDefense());
        $this->assertEquals(10, $regiment->getAmount());
    }
}
