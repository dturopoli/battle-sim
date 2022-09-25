<?php

namespace App\Service\Factory;

use App\Contract\Model\ArmyInterface;
use App\Contract\Service\ArmyFactoryInterface;
use App\Contract\Service\RegimentFactoryInterface;
use App\Model\Army;
use App\Repository\UnitRepository;

class ArmyFactory implements ArmyFactoryInterface
{
    /**
     * @param UnitRepository $unitRepository
     * @param RegimentFactoryInterface $regimentFactory
     * @param string[] $validUnitTypes
     */
    public function __construct(
        private UnitRepository $unitRepository,
        private RegimentFactoryInterface $regimentFactory,
        private array $validUnitTypes = []
    ) {
    }

    /**
     * @inheritDoc
     */
    public function create(string $name, int $numberOfTroops): ArmyInterface
    {
        $army = new Army();

        $army
            ->setName($name)
            ->setMoral(100);

        // Determine units that will be used for each unit type
        $units = [];
        foreach ($this->validUnitTypes as $validUnitType) {
            $randomUnit = $this->unitRepository->randomUnitOfType($validUnitType);

            if ($randomUnit) {
                $units[] = $this->unitRepository->randomUnitOfType($validUnitType);
            }
        }

        shuffle($units);
        $lastUnit = array_pop($units);

        foreach ($units as $unit) {
            if ($numberOfTroops == 0) {
                break;
            }

            $amount = rand(0, $numberOfTroops);

            if ($amount == 0) {
                continue;
            }

            $army->addRegiment($this->regimentFactory->create($unit, $amount));
            $numberOfTroops -= $amount;
        }

        // If there are still some troops left use last unit form units array to create regiment
        if ($numberOfTroops) {
            $army->addRegiment($this->regimentFactory->create($lastUnit, $numberOfTroops));
        }

        return $army;
    }
}
