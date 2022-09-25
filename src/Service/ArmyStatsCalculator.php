<?php

namespace App\Service;

use App\Contract\Model\ArmyInterface;
use App\Contract\Service\ArmyStatsCalculatorInterface;

class ArmyStatsCalculator implements ArmyStatsCalculatorInterface
{
    /**
     * @inheritDoc
     */
    public function attack(ArmyInterface $army): int
    {
        $attack = 0;

        foreach ($army->getRegiments() as $regiment) {
            $attack += $regiment->getUnit()->getAttack() * $regiment->getAmount();
        }

        return $attack;
    }

    /**
     * @inheritDoc
     */
    public function defense(ArmyInterface $army): int
    {
        $attack = 0;

        foreach ($army->getRegiments() as $regiment) {
            $attack += $regiment->getUnit()->getDefense() * $regiment->getAmount();
        }

        return $attack;
    }

    /**
     * @inheritDoc
     */
    public function calculateModifiedAttack(ArmyInterface $army): float
    {
        $attack = $this->attack($army);

        foreach ($army->getModifiers() as $modifier) {
            $attack *= $modifier->getValue();
        }

        return $attack;
    }

    /**
     * @inheritDoc
     */
    public function calculateModifiedDefense(ArmyInterface $army): float
    {
        $defense = $this->defense($army);

        foreach ($army->getModifiers() as $modifier) {
            $defense *= $modifier->getValue();
        }

        return $defense;
    }
}
