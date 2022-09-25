<?php

namespace App\Contract\Service;

use App\Contract\Model\ArmyInterface;

interface ArmyFactoryInterface
{
    /**
     * Create army based on number of given troops
     * @param string $name
     * @param int $numberOfTroops
     * @return ArmyInterface
     */
    public function create(string $name, int $numberOfTroops): ArmyInterface;
}
