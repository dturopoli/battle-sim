<?php

namespace App\Contract\Model;

interface BattleResultInterface
{
    /**
     * @param BattleInterface $battle
     * @return $this
     */
    public function setBattle(BattleInterface $battle): self;

    /**
     * @return BattleInterface|null
     */
    public function getBattle(): ?BattleInterface;

    /**
     * @return array<mixed>
     */
    public function getStats(): array;

    /**
     * @param array<mixed> $stats
     * @return BattleResultInterface
     */
    public function setStats(array $stats): self;

    /**
     * @return ArmyInterface|null
     */
    public function getWinner(): ?ArmyInterface;

    /**
     * @param ArmyInterface $army
     * @return $this
     */
    public function setWinner(ArmyInterface $army): self;
}
