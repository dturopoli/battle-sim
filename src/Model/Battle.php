<?php

namespace App\Model;

use App\Contract\Model\ArmyInterface;
use App\Contract\Model\BattleInterface;
use App\Contract\Model\BattleResultInterface;
use App\Contract\Model\TerrainInterface;

class Battle implements BattleInterface
{
    private ?ArmyInterface $attacker = null;

    private ?ArmyInterface $defender = null;

    private ?TerrainInterface $terrain = null;

    private ?BattleResultInterface $battleResult = null;

    /**
     * @inheritDoc
     */
    public function getAttacker(): ?ArmyInterface
    {
        return $this->attacker;
    }

    /**
     * @param ArmyInterface $army
     * @return $this
     */
    public function setAttacker(ArmyInterface $army): self
    {
        $this->attacker = $army;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDefender(): ?ArmyInterface
    {
        return $this->defender;
    }

    /**
     * @param ArmyInterface $army
     * @return $this
     */
    public function setDefender(ArmyInterface $army): self
    {
        $this->defender = $army;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getTerrain(): ?TerrainInterface
    {
        return $this->terrain;
    }

    /**
     * @param TerrainInterface|null $terrain
     * @return $this
     */
    public function setTerrain(?TerrainInterface $terrain): self
    {
        $this->terrain = $terrain;
        return $this;
    }

    /**
     * @return BattleResultInterface|null
     */
    public function getBattleResults(): ?BattleResultInterface
    {
        return $this->battleResult;
    }

    /**
     * @param BattleResultInterface $battleResult
     * @return $this
     */
    public function setBattleResults(BattleResultInterface $battleResult): self
    {
        $this->battleResult = $battleResult;
        return $this;
    }
}
