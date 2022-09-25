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
     * @param array $validUnitTypes
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

        // Determine unit types that will be used for each unit type
        $units = [];
        foreach ($this->validUnitTypes as $validUnitType) {
            $units[] = $this->unitRepository->randomUnitOfType($validUnitType);
        }

        $countOfUnits = count($units);

        foreach ($units as $key => $unit) {
            // If no more available troops add empty regiments
            if ($numberOfTroops == 0) {
                $army->addRegiment($this->regimentFactory->create($unit, 0));
                continue;
            }

            // If last unit add rest of troops to that regiment
            if ($key == $countOfUnits - 1) {
                $amount = $numberOfTroops;
            } else {
                $amount = rand(0, $numberOfTroops);
            }

            $army->addRegiment($this->regimentFactory->create($unit, $amount));
            $numberOfTroops -= $amount;
        }

        return $army;
    }
}
