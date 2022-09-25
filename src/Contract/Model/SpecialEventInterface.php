<?php

namespace App\Contract\Model;

interface SpecialEventInterface
{
    public function getName(): ?string;

    public function getDescription(): ?string;

    public function getModifier(): ?float;
}
