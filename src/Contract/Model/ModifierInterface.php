<?php

namespace App\Contract\Model;

interface ModifierInterface
{
    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @return float|null
     */
    public function getValue(): ?float;
}
