<?php

namespace App\Service;

use App\Contract\Service\DiceRollerInterface;

class DiceRoller implements DiceRollerInterface
{
    /**
     * @param int $diceSize
     * @return int
     */
    public function roll(int $diceSize = 6): int
    {
        return rand(1, $diceSize);
    }
}
