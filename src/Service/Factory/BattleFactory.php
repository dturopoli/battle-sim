<?php

namespace App\Service\Factory;

use App\Contract\Model\ArmyInterface;
use App\Contract\Model\BattleInterface;
use App\Contract\Model\TerrainInterface;
use App\Contract\Service\BattleFactoryInterface;
use App\Model\Battle;
use App\Repository\TerrainRepository;

class BattleFactory implements BattleFactoryInterface
{
    public function __construct(
        private TerrainRepository $terrainRepository
    ) {
    }

    /**
     * Create battle, determine attacker, defender and terrain and modifiers
     * @param ArmyInterface $army1
     * @param ArmyInterface $army2
     * @return BattleInterface
     */
    public function create(ArmyInterface $army1, ArmyInterface $army2): BattleInterface
    {
        $terrain = $this->determineTerrain();

        $battle = new Battle();

        // Determine attacker and defender
        $armyPool = [$army1, $army2];
        shuffle($armyPool);

        $attacker = array_pop($armyPool);
        $defender = array_pop($armyPool);

        $battle
            ->setAttacker($attacker)
            ->setDefender($defender)
            ->setTerrain($terrain);

        return $battle;
    }

    /**
     * @return TerrainInterface|null
     */
    private function determineTerrain(): ?TerrainInterface
    {
        return $this->terrainRepository->random();
    }
}
