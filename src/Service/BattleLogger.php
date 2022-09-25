<?php

namespace App\Service;

use App\Contract\Model\ArmyInterface;
use App\Contract\Model\BattleInterface;
use App\Contract\Model\BattleResultInterface;
use App\Contract\Service\BattleLoggerInterface;
use App\Contract\Service\BattleResultsFactoryInterface;

class BattleLogger implements BattleLoggerInterface
{
    public function __construct(private BattleResultsFactoryInterface $battleResultsFactory)
    {
    }

    /**
     * @inheritDoc
     */
    public function startLog(BattleInterface $battle): BattleResultInterface
    {
        $battleResults = $this->battleResultsFactory->create();

        $battleResults->setBattle($battle);
        $battle->setBattleResults($battleResults);

        return $battleResults;
    }

    /**
     * @inheritDoc
     */
    public function logPhase(string $phaseId, BattleInterface $battle): void
    {
        $battleResult = $battle->getBattleResults();

        if (!$battleResult) {
            $battleResult = $this->startLog($battle);
        }

        $attacker = $battle->getAttacker();
        $defender = $battle->getDefender();

        $stats = $battleResult->getStats();

        $stats[$phaseId] = [
            'attacker' => [
                'moral' => $attacker->getMoral(),
                'regiments' => $this->logRegiments($attacker),
                'modifiers' => $this->logModifiers($attacker),
            ],
            'defender' => [
                'moral' => $defender->getMoral(),
                'regiments' => $this->logRegiments($defender),
                'modifiers' => $this->logModifiers($defender),
            ],
        ];

        $battleResult->setStats($stats);
    }

    /**
     * @param ArmyInterface $army
     * @return array<int,array<string,mixed>>
     */
    private function logModifiers(ArmyInterface $army): array
    {
        $data = [];

        foreach ($army->getModifiers() as $modifier) {
            $data[] = [
                'name' => $modifier->getName(),
                'value' => $modifier->getValue(),
            ];
        }

        return $data;
    }

    /**
     * @param ArmyInterface $army
     * @return array<int,array<string,mixed>>
     */
    private function logRegiments(ArmyInterface $army): array
    {
        $data = [];

        foreach ($army->getRegiments() as $regiment) {
            $data[] = [
                'unit' => $regiment->getUnit()->getName(),
                'amount' => $regiment->getAmount(),
            ];
        }

        return $data;
    }
}
