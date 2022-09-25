<?php

namespace App\Http\Request;

use Symfony\Component\Validator\Constraints as Assert;

class BattleRequest extends AbstractRequest
{
    #[Assert\NotBlank]
    #[Assert\Positive]
    protected int $army1;

    #[Assert\NotBlank]
    #[Assert\Positive]
    protected int $army2;

    /**
     * @return int
     */
    public function getArmy1(): int
    {
        return $this->army1;
    }

    /**
     * @return int
     */
    public function getArmy2(): int
    {
        return $this->army2;
    }

    /**
     * @param $value
     */
    protected function setArmy1($value)
    {
        $this->army1 = (int) $value;
    }

    /**
     * @param $value
     */
    protected function setArmy2($value)
    {
        $this->army2 = (int) $value;
    }
}
