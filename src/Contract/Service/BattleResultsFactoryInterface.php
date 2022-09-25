<?php

namespace App\Contract\Service;

use App\Contract\Model\BattleResultInterface;

interface BattleResultsFactoryInterface
{
    /**
     * @return BattleResultInterface
     */
    public function create(): BattleResultInterface;
}
