<?php

namespace App\Service\Factory;

use App\Contract\Model\RegimentInterface;
use App\Contract\Model\UnitInterface;
use App\Contract\Service\RegimentFactoryInterface;
use App\Model\Regiment;

class RegimentFactory implements RegimentFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(UnitInterface $unit, int $amount): RegimentInterface
    {
        $regiment = new Regiment();

        $regiment
            ->setUnit($unit)
            ->setAmount($amount);

        return $regiment;
    }
}
