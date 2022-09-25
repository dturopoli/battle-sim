<?php

namespace App\Service\Factory;

use App\Contract\Model\ModifierInterface;
use App\Contract\Service\ModifierFactoryInterface;
use App\Model\Modifier;

class ModifierFactory implements ModifierFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(string $name, float $value): ModifierInterface
    {
        $modifier = new Modifier();

        $modifier->setName($name)
            ->setValue($value);

        return $modifier;
    }
}
