<?php

namespace App\Contract\Model;

interface RegimentInterface
{
    /**
     * @return UnitInterface|null
     */
    public function getUnit(): ?UnitInterface;

    /**
     * @return int|null
     */
    public function getAmount(): ?int;

    /**
     * @param int $amount
     * @return $this
     */
    public function setAmount(int $amount): self;
}
