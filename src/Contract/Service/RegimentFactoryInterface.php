<?php

namespace App\Contract\Service;

use App\Contract\Model\RegimentInterface;
use App\Contract\Model\UnitInterface;

interface RegimentFactoryInterface
{
    /**
     * @param UnitInterface $unit
     * @param int $amount
     * @return RegimentInterface
     */
    public function create(UnitInterface $unit, int $amount): RegimentInterface;
}
