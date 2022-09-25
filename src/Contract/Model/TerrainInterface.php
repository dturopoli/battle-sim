<?php

namespace App\Contract\Model;

interface TerrainInterface
{
    /**
     * @return float|null
     */
    public function getAttackerModifier(): ?float;


    /**
     * @return float|null
     */
    public function getDefenderModifier(): ?float;

    /**
     * @return string|null
     */
    public function getName(): ?string;
}
