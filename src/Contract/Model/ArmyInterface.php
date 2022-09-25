<?php

namespace App\Contract\Model;

interface ArmyInterface
{
    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param float $moral
     * @return ArmyInterface
     */
    public function setMoral(float $moral): self;

    /**
     * @return float|null
     */
    public function getMoral(): ?float;

    /**
     * @param RegimentInterface $regiment
     * @return ArmyInterface
     */
    public function addRegiment(RegimentInterface $regiment): self;

    /**
     * @return RegimentInterface[]
     */
    public function getRegiments(): array;

    /**
     * @param ModifierInterface $modifier
     * @return ArmyInterface
     */
    public function addModifier(ModifierInterface $modifier): self;

    /**
     * @return ModifierInterface[]
     */
    public function getModifiers(): array;

    public function clearModifiers();

    /**
     * @return int
     */
    public function getNumberOfTroops(): int;
}
