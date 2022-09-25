<?php

namespace App\Contract\Service;

use App\Contract\Model\ArmyInterface;

interface ArmyServiceInterface
{
    /**
     * Apply modifier to army
     * @param ArmyInterface $army
     * @param string $name
     * @param float $value
     */
    public function applyModifier(ArmyInterface $army, string $name, float $value): void;

    /**
     * Adjust number of troops based on modifier
     * @param ArmyInterface $army
     * @param float $modifier
     */
    public function updateNumberOfRegimentTroops(ArmyInterface $army, float $modifier): void;

    /**
     * Adjust moral of armies based on modifier
     * @param ArmyInterface $army
     * @param float $modifier
     */
    public function adjustMoral(ArmyInterface $army, float $modifier): void;
}
