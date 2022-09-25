<?php

namespace App\Tests\Service\Factory;

use App\Contract\Model\ArmyInterface;
use App\Contract\Service\ArmyFactoryInterface;
use App\Contract\Service\BattleFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BattleFactoryTest extends KernelTestCase
{
    /**
     * @depends  App\Tests\Service\Factory\ArmyFactoryTest::testCreate
     */
    public function testCreate(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        /** @var ArmyFactoryInterface $armyBuilder */
        $armyFactory = $container->get(ArmyFactoryInterface::class);

        /** @var BattleFactoryInterface $battleFactory */
        $battleFactory = $container->get(BattleFactoryInterface::class);

        $army1 = $armyFactory->create('army_1', 100);
        $army2 = $armyFactory->create('army_2', 100);

        $battle = $battleFactory->create($army1, $army2);

        $this->assertInstanceOf(ArmyInterface::class, $battle->getAttacker());
        $this->assertInstanceOf(ArmyInterface::class, $battle->getDefender());

        if ($battle->getAttacker()->getName() == 'army_1') {
            $this->assertEquals('army_2', $battle->getDefender()->getName());
        } else {
            $this->assertEquals('army_1', $battle->getDefender()->getName());
        }
    }
}
