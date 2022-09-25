<?php

namespace App\Contract\Model;

interface UnitInterface
{
    /**
     * @return int|null
     */
    public function getAttack(): ?int;

    /**
     * @return int|null
     */
    public function getDefense(): ?int;

    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @return UnitTypeInterface|null
     */
    public function getUnitType(): ?UnitTypeInterface;
}
