<?php

namespace App\Contract\Service;

use App\Contract\Model\ArmyInterface;

interface ArmyStatsCalculatorInterface
{
    /**
     * Calculate army attack points
     * @param ArmyInterface $army
     * @return int
     */
    public function attack(ArmyInterface $army): int;

    /**
     * Calculate army defense points
     * @param ArmyInterface $army
     * @return int
     */
    public function defense(ArmyInterface $army): int;

    /**
     * Calculate army attack points with included modifiers
     * @param ArmyInterface $army
     * @return float
     */
    public function calculateModifiedAttack(ArmyInterface $army): float;

    /**
     * Calculate army defense points with included modifiers
     * @param ArmyInterface $army
     * @return mixed
     */
    public function calculateModifiedDefense(ArmyInterface $army): float;
}
