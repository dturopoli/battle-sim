<?php

namespace App\Contract\Model;

interface BattleResultInterface
{
    /**
     * @return BattleInterface|null
     */
    public function getBattle(): ?BattleInterface;

    /**
     * @return array
     */
    public function getStats(): array;

    /**
     * @param array $stats
     * @return BattleResultInterface
     */
    public function setStats(array $stats): self;

    /**
     * @return ArmyInterface|null
     */
    public function getWinner(): ?ArmyInterface;
}
