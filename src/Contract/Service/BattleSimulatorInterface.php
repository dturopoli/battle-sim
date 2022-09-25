<?php

namespace App\Contract\Service;

use App\Contract\Model\BattleInterface;

interface BattleSimulatorInterface
{
    public function simulate(BattleInterface $battle);
}
