<?php

namespace App\Model;

use App\Contract\Model\RegimentInterface;
use App\Contract\Model\UnitInterface;

class Regiment implements RegimentInterface
{
    private ?UnitInterface $unit = null;

    private ?int $amount = null;

    /**
     * @inheritDoc
     */
    public function getUnit(): ?UnitInterface
    {
        return $this->unit;
    }

    public function setUnit(UnitInterface $unit): self
    {
        $this->unit = $unit;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return $this
     */
    public function setAmount(int $amount): self
    {
        $this->amount = $amount;
        return $this;
    }
}
