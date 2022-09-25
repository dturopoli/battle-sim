<?php

namespace App\Http\Request;

use Symfony\Component\Validator\Constraints as Assert;

class BattleRequest extends AbstractRequest
{
    #[Assert\NotBlank]
    #[Assert\Type('numeric')]
    #[Assert\Positive]
    #[Assert\Range(min: 1, max: 1000000000)]
    protected $army1;

    #[Assert\NotBlank]
    #[Assert\Type('numeric')]
    #[Assert\Range(min: 1, max: 1000000000)]
    protected $army2;

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
        $this->army1 = $value;
    }

    /**
     * @param $value
     */
    protected function setArmy2($value)
    {
        $this->army2 = $value;
    }
}
