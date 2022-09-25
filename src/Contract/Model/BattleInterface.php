<?php

namespace App\Contract\Model;

interface BattleInterface
{
    /**
     * @return ArmyInterface|null
     */
    public function getAttacker(): ?ArmyInterface;

    /**
     * @return ArmyInterface|null
     */
    public function getDefender(): ?ArmyInterface;

    /**
     * @return TerrainInterface|null
     */
    public function getTerrain(): ?TerrainInterface;

    /**
     * @return BattleResultInterface|null
     */
    public function getBattleResults(): ?BattleResultInterface;

    /**
     * @param BattleResultInterface $battleResult
     * @return $this
     */
    public function setBattleResults(BattleResultInterface $battleResult): self;
}
