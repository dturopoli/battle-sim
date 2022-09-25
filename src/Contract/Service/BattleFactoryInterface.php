<?php

namespace App\Contract\Service;

use App\Contract\Model\ArmyInterface;
use App\Contract\Model\BattleInterface;

interface BattleFactoryInterface
{
    /**
     * Create battle of two armies
     * @param ArmyInterface $army1
     * @param ArmyInterface $army2
     * @return BattleInterface
     */
    public function create(ArmyInterface $army1, ArmyInterface $army2): BattleInterface;
}
