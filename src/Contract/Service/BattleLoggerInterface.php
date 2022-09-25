<?php

namespace App\Contract\Service;

use App\Contract\Model\BattleInterface;
use App\Contract\Model\BattleResultInterface;

interface BattleLoggerInterface
{
    /**
     * @param BattleInterface $battle
     * @return BattleResultInterface
     */
    public function startLog(BattleInterface $battle): BattleResultInterface;

    /**
     * @param string $phaseId
     * @param BattleInterface $battle
     * @return void
     */
    public function logPhase(string $phaseId, BattleInterface $battle): void;
}
