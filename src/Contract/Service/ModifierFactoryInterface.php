<?php

namespace App\Contract\Service;

use App\Contract\Model\ModifierInterface;

interface ModifierFactoryInterface
{
    /**
     * @param string $name
     * @param float $value
     * @return ModifierInterface
     */
    public function create(string $name, float $value): ModifierInterface;
}
