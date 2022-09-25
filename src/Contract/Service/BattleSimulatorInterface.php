<?php

namespace App\Contract\Service;

use App\Contract\Model\BattleInterface;

interface BattleSimulatorInterface
{
    /**
     * Simulate battle
     * @param BattleInterface $battle
     */
    public function simulate(BattleInterface $battle): void;
}
