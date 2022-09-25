<?php

namespace App\Model;

use App\Contract\Model\ModifierInterface;

class Modifier implements ModifierInterface
{
    private ?string $name = null;

    private ?float $value = null;

    /**
     * @param string $name
     * @return ModifierInterface
     */
    public function setName(string $name): ModifierInterface
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getValue(): ?float
    {
        return $this->value;
    }

    /**
     * @param float $value
     * @return ModifierInterface
     */
    public function setValue(float $value): ModifierInterface
    {
        $this->value = $value;
        return $this;
    }
}
