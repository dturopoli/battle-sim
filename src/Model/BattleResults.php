<?php

namespace App\Model;

use App\Contract\Model\ArmyInterface;
use App\Contract\Model\BattleInterface;
use App\Contract\Model\BattleResultInterface;

class BattleResults implements BattleResultInterface
{
    private ?BattleInterface $battle = null;

    private ?ArmyInterface $winner = null;

    /**
     * @var mixed[]
     */
    private array $stats = [];

    /**
     * @inheritDoc
     */
    public function setStats(array $stats): self
    {
        $this->stats = $stats;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getStats(): array
    {
        return $this->stats;
    }

    /**
     * @param BattleInterface $battle
     * @return $this
     */
    public function setBattle(BattleInterface $battle): self
    {
        $this->battle = $battle;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getBattle(): ?BattleInterface
    {
        return $this->battle;
    }

    /**
     * @inheritDoc
     */
    public function getWinner(): ?ArmyInterface
    {
        return $this->winner;
    }

    /**
     * @param ArmyInterface $army
     * @return $this
     */
    public function setWinner(ArmyInterface $army): self
    {
        $this->winner = $army;
        return $this;
    }
}
