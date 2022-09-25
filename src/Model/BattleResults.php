<?php

namespace App\Model;

use App\Contract\Model\ArmyInterface;
use App\Contract\Model\BattleInterface;
use App\Contract\Model\BattleResultInterface;

class BattleResults implements BattleResultInterface
{
    private ?BattleInterface $battle = null;

    private ?Army $winner = null;

    private array $stats = [];

    /**
     * @inheritDoc
     */
    public function setStats(array $stats): BattleResultInterface
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
     * @return BattleResultInterface
     */
    public function setBattle(BattleInterface $battle): BattleResultInterface
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
     * @return BattleResultInterface
     */
    public function setWinner(ArmyInterface $army): BattleResultInterface
    {
        $this->winner = $army;
        return $this;
    }

    /**
     * @return array
     */
    public function __serialize(): array
    {
        return [
            'winner' => $this->getWinner(),
            'stats' => $this->getStats(),
        ];
    }
}
