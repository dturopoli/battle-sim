<?php

namespace App\Model;

use App\Contract\Model\ArmyInterface;
use App\Contract\Model\ModifierInterface;
use App\Contract\Model\RegimentInterface;

class Army implements ArmyInterface
{
    private ?string $name = null;

    private float $moral = 100;

    /**
     * @var ModifierInterface[]
     */
    private array $modifiers = [];

    /**
     * @var RegimentInterface[]
     */
    private array $regiments = [];

    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ArmyInterface
     */
    public function setName(string $name): ArmyInterface
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getMoral(): ?float
    {
        return $this->moral;
    }

    /**
     * @param float $moral
     * @return Army
     */
    public function setMoral(float $moral): self
    {
        $this->moral = round($moral, 2);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addModifier(ModifierInterface $modifier): ArmyInterface
    {
        $this->modifiers[$modifier->getName()] = $modifier;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getModifiers(): array
    {
        return $this->modifiers;
    }

    public function clearModifiers()
    {
        $this->modifiers = [];
    }

    /**
     * @inheritDoc
     */
    public function addRegiment(RegimentInterface $regiment): ArmyInterface
    {
        $this->regiments[] = $regiment;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRegiments(): array
    {
        return $this->regiments;
    }

    /**
     * @return int
     */
    public function getNumberOfTroops(): int
    {
        $count = 0;

        foreach ($this->getRegiments() as $regiment) {
            $count += $regiment->getAmount();
        }

        return $count;
    }
}
