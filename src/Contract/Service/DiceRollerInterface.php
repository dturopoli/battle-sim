<?php

namespace App\Contract\Service;

interface DiceRollerInterface
{
    /**
     * @param int $diceSize
     * @return int
     */
    public function roll(int $diceSize = 6): int;
}
