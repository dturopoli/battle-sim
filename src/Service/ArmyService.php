<?php

namespace App\Service;

use App\Contract\Model\ArmyInterface;
use App\Contract\Service\ArmyServiceInterface;
use App\Contract\Service\ModifierFactoryInterface;

class ArmyService implements ArmyServiceInterface
{
    public function __construct(private ModifierFactoryInterface $modifierFactory)
    {
    }

    /**
     * @inheritDoc
     */
    public function applyModifier(ArmyInterface $army, string $name, float $value): void
    {
        $army->addModifier($this->modifierFactory->create($name, $value));
    }

    /**
     * @inheritDoc
     */
    public function updateNumberOfRegimentTroops(ArmyInterface $army, float $modifier): void
    {
        $modifier = round($modifier, 4);

        foreach ($army->getRegiments() as $regiment) {
            if ($regiment->getAmount() == 0) {
                continue;
            }

            $amount = $regiment->getAmount();
            $newAmount = $amount - round($amount * $modifier);

            $regiment->setAmount($newAmount);
        }
    }


    /**
     * Adjust moral of armies based on modifier
     * @param ArmyInterface $army
     * @param float $modifier
     */
    public function adjustMoral(ArmyInterface $army, float $modifier): void
    {
        $currentMoral = $army->getMoral();

        $army->setMoral($currentMoral - $currentMoral * $modifier);
    }
}
