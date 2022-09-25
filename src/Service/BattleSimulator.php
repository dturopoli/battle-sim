<?php

namespace App\Service;

use App\Contract\Model\BattleInterface;
use App\Contract\Service\ArmyServiceInterface;
use App\Contract\Service\ArmyStatsCalculatorInterface;
use App\Contract\Service\BattleLoggerInterface;
use App\Contract\Service\BattleSimulatorInterface;
use App\Contract\Model\ArmyInterface;
use App\Contract\Service\DiceRollerInterface;
use App\Exception\BattleTooLongException;
use App\Repository\SpecialEventRepository;

class BattleSimulator implements BattleSimulatorInterface
{
    public function __construct(
        private DiceRollerInterface $diceRoller,
        private ArmyStatsCalculatorInterface $armyStatsCalculator,
        private BattleLoggerInterface $battleLogger,
        private SpecialEventRepository $specialEventRepository,
        private ArmyServiceInterface $armyService,
        private bool $enableSpecialEvents = false
    ) {
    }

    /**
     * Simulate battle and return results
     * @param BattleInterface $battle
     * @throws BattleTooLongException
     */
    public function simulate(BattleInterface $battle): void
    {
        $this->prepareBattle($battle);
        $this->startBattle($battle);
        $this->endBattle($battle);
    }

    /**
     * Do battle preparations (start log, apply battle specific modifiers)
     * @param BattleInterface $battle
     */
    private function prepareBattle(BattleInterface $battle): void
    {
        $this->battleLogger->logPhase('Start', $battle);

        // Apply battle modifiers to armies
        $this->applyBattleModifiers($battle);
    }

    /**
     * End battle (determine winner)
     * @param BattleInterface $battle
     */
    private function endBattle(BattleInterface $battle): void
    {
        $battleResults = $battle->getBattleResults();

        $attacker = $battle->getAttacker();
        $defender = $battle->getDefender();

        // Determine winner
        if ($attacker->getMoral() <= 0 || $attacker->getNumberOfTroops() <= 0) {
            $battleResults->setWinner($defender);
        } else {
            $battleResults->setWinner($attacker);
        }
    }

    /**
     * Start the battle :)
     * @param BattleInterface $battle
     * @throws BattleTooLongException
     */
    private function startBattle(BattleInterface $battle): void
    {
        $attacker = $battle->getAttacker();
        $defender = $battle->getDefender();

        // Start the battle and fight until one army losses all moral or troops
        $phase = 0;
        while (
            $attacker->getMoral() > 0 &&
            $attacker->getNumberOfTroops() &&
            $defender->getMoral() > 0 &&
            $defender->getNumberOfTroops()
        ) {
            $this->executePhase($battle);

            $this->battleLogger->logPhase("Phase $phase", $battle);
            $phase++;

            // Make sure to exit while
            if ($phase > 50) {
                throw new BattleTooLongException('Battle took over 50 phases.');
            }
        }
    }

    /**
     * @param BattleInterface $battle
     */
    private function executePhase(BattleInterface $battle): void
    {
        $attacker = $battle->getAttacker();
        $defender = $battle->getDefender();

        // This means that attacker or defender has no units left
        if (!$attacker->getNumberOfTroops() && !$defender->getNumberOfTroops()) {
            return;
        }

        // Apply special event modifier
        if ($this->enableSpecialEvents) {
            $this->applySpecialEventModifier($battle);
        }

        // Apply phase modifiers
        $this->applyPhaseModifiersToArmy($attacker);
        $this->applyPhaseModifiersToArmy($defender);

        $attackerTotalStats = $this->armyStatsCalculator->calculateModifiedAttack($attacker);
        $defenderTotalStats = $this->armyStatsCalculator->calculateModifiedDefense($defender);

        // Attacker won this turn
        if ($attackerTotalStats > $defenderTotalStats) {
            $winner = $attacker;
            $loser = $defender;

            $winnerStats = $attackerTotalStats;
            $loserStats = $defenderTotalStats;
        // Defender won this turn, defender also wins if it's a tie
        } else {
            $winner = $defender;
            $loser = $attacker;

            $winnerStats = $defenderTotalStats;
            $loserStats = $attackerTotalStats;
        }

        $combinedStats = $winnerStats + $loserStats;

        $winnerArmyLossModifier = $loserStats / $combinedStats;
        $loserArmyLossModifier = $winnerStats / $combinedStats;

        $this->armyService->updateNumberOfRegimentTroops($winner, $winnerArmyLossModifier);
        $this->armyService->updateNumberOfRegimentTroops($loser, $loserArmyLossModifier);

        $this->armyService->adjustMoral($loser, $loserArmyLossModifier * 0.5);
        $this->armyService->adjustMoral($winner, $winnerArmyLossModifier * 0.5);
    }

    /**
     * Apply battle specific modifiers (at the moment only terrain modifier is applied)
     * @param BattleInterface $battle
     */
    private function applyBattleModifiers(BattleInterface $battle): void
    {
        $terrain = $battle->getTerrain();

        if (!$terrain) {
            return;
        }

        $attacker = $battle->getAttacker();
        $defender = $battle->getDefender();

        $this->armyService->applyModifier($attacker, 'terrain', $terrain->getAttackerModifier());
        $this->armyService->applyModifier($defender, 'terrain', $terrain->getDefenderModifier());
    }

    /**
     * Applies phase modifiers to army (moral, dice roll) and additional modifiers
     * @param ArmyInterface $army
     */
    private function applyPhaseModifiersToArmy(ArmyInterface $army): void
    {
        $diceRoll = $this->diceRoller->roll();

        $this->armyService->applyModifier($army, 'moral', $army->getMoral() * 0.01);
        $this->armyService->applyModifier($army, 'dice_roll', $diceRoll);
    }

    /**
     * If two dice rolls match apply random special event modifier
     * @param BattleInterface $battle
     */
    private function applySpecialEventModifier(BattleInterface $battle): void
    {
        $roll = $this->diceRoller->roll(10);
        $roll2 = $this->diceRoller->roll(10);

        if ($roll != $roll2) {
            return;
        }

        $specialEvent = $this->specialEventRepository->random();

        if (!$specialEvent) {
            return;
        }

        $armies = [$battle->getAttacker(), $battle->getDefender()];
        shuffle($armies);

        /** @var ArmyInterface $army */
        $army = array_pop($armies);

        $this->armyService->applyModifier($army, $specialEvent->getName(), $specialEvent->getModifier());
    }
}
