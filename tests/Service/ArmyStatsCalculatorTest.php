<?php

namespace App\Tests\Service;

use App\Contract\Model\ArmyInterface;
use App\Contract\Service\ArmyStatsCalculatorInterface;
use App\Entity\Unit;
use App\Model\Army;
use App\Model\Modifier;
use App\Model\Regiment;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArmyStatsCalculatorTest extends WebTestCase
{
    private ?ArmyStatsCalculatorInterface $armyStatsCalculator = null;

    public function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $this->armyStatsCalculator = $container->get(ArmyStatsCalculatorInterface::class);
    }

    /**
     * @dataProvider armyProvider
     */
    public function testModifiedCalculations(ArmyInterface $army, float $attack, float $defense)
    {
        $this->assertEquals(
            $attack,
            $this->armyStatsCalculator->calculateModifiedAttack($army)
        );

        $this->assertEquals(
            $defense,
            $this->armyStatsCalculator->calculateModifiedDefense($army)
        );
    }

    public function armyProvider()
    {
        $unit1 = new Unit();
        $unit1->setName('unit1')
            ->setAttack(1)
            ->setDefense(2);

        $unit2 = new Unit();
        $unit2->setName('unit2')
            ->setAttack(5)
            ->setDefense(4);


        $regiment1 = new Regiment();
        $regiment1->setUnit($unit1)
            ->setAmount(20);

        $regiment1Attack = 20 * 1;
        $regiment1Defense = 20 * 2;

        $regiment2 = new Regiment();
        $regiment2->setUnit($unit2)
            ->setAmount(15);

        $regiment2Attack = 15 * 5;
        $regiment2Defense = 15 * 4;

        $modifier = new Modifier();
        $modifier->setName('test')
            ->setValue(0.3);

        $army = new Army();

        $army->setName('army')
            ->addRegiment($regiment1)
            ->addRegiment($regiment2)
            ->addModifier($modifier);

        $armyModifiedAttack = ($regiment1Attack + $regiment2Attack) * $modifier->getValue();
        $armyModifiedDefense = ($regiment1Defense + $regiment2Defense) * $modifier->getValue();

        return [
            [$army, $armyModifiedAttack, $armyModifiedDefense]
        ];
    }
}
