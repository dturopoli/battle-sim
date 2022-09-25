<?php

namespace App\Service\Factory;

use App\Contract\Model\BattleResultInterface;
use App\Contract\Service\BattleResultsFactoryInterface;
use App\Model\BattleResults;

class BattleResultsFactory implements BattleResultsFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(): BattleResultInterface
    {
        return new BattleResults();
    }
}
