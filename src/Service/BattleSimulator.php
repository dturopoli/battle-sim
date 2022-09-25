<?php

namespace App\Service;

use App\Contract\Model\BattleInterface;
use App\Contract\Service\ArmyStatsCalculatorInterface;
use App\Contract\Service\BattleLoggerInterface;
use App\Contract\Service\BattleSimulatorInterface;
use App\Contract\Model\ArmyInterface;
use App\Contract\Service\DiceRollerInterface;
use App\Contract\Service\ModifierFactoryInterface;
use App\Repository\SpecialEventRepository;

class BattleSimulator implements BattleSimulatorInterface
{
    public function __construct(
        private DiceRollerInterface $diceRoller,
        private ArmyStatsCalculatorInterface $armyStatsCalculator,
        private ModifierFactoryInterface $modifierFactory,
        private BattleLoggerInterface $battleLogger,
        private SpecialEventRepository $specialEventRepository,
        private bool $enableSpecialEvents = false
    ) {
    }

    /**
     * Simulate battle and return results
     * @param BattleInterface $battle
     */
    public function simulate(BattleInterface $battle)
    {
        $this->prepareBattle($battle);
        $this->startBattle($battle);
        $this->endBattle($battle);
    }

    /**
     * Do battle preparations (start log, apply battle specific modifiers)
     * @param BattleInterface $battle
     */
    private function prepareBattle(BattleInterface $battle)
    {
        $this->battleLogger->logPhase('Start', $battle);

        // Apply battle modifiers to armies
        $this->applyBattleModifiers($battle);
    }

    /**
     * End battle (determine winner)
     * @param BattleInterface $battle
     */
    private function endBattle(BattleInterface $battle)
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
     */
    private function startBattle(BattleInterface $battle)
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
        }
    }

    /**
     * @param BattleInterface $battle
     */
    private function executePhase(BattleInterface $battle)
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

        $this->updateNumberOfRegimentTroops($winner, $winnerArmyLossModifier);
        $this->updateNumberOfRegimentTroops($loser, $loserArmyLossModifier);

        $this->adjustMoral($loser, $loserArmyLossModifier * 0.5);
        $this->adjustMoral($winner, $winnerArmyLossModifier * 0.5);
    }

    /**
     * Apply battle specific modifiers
     * @param BattleInterface $battle
     */
    private function applyBattleModifiers(BattleInterface $battle)
    {
        $attacker = $battle->getAttacker();
        $defender = $battle->getDefender();

        $terrain = $battle->getTerrain();

        if (!$terrain) {
            return;
        }

        $attacker->addModifier($this->modifierFactory->create('terrain', $terrain->getAttackerModifier()));
        $defender->addModifier($this->modifierFactory->create('terrain', $terrain->getDefenderModifier()));
    }

    /**
     * Applies phase modifiers to army (moral, dice roll) and additional modifiers
     * @param ArmyInterface $army
     */
    private function applyPhaseModifiersToArmy(ArmyInterface $army)
    {
        $diceRoll = $this->diceRoller->roll();

        $army->addModifier($this->modifierFactory->create('moral', $army->getMoral() * 0.01));
        $army->addModifier($this->modifierFactory->create('dice_roll', $diceRoll));
    }

    /**
     * @param BattleInterface $battle
     */
    private function applySpecialEventModifier(BattleInterface $battle)
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

        $army->addModifier($this->modifierFactory->create($specialEvent->getName(), $specialEvent->getModifier()));
    }

    /**
     * Adjust moral of armies based on modifier
     * @param ArmyInterface $army
     * @param float $modifier
     */
    private function adjustMoral(ArmyInterface $army, float $modifier)
    {
        $currentMoral = $army->getMoral();

        $army->setMoral($currentMoral - $currentMoral * $modifier);
    }

    /**
     * Adjust number of troops based on modifier
     * @param ArmyInterface $army
     * @param float $modifier
     */
    private function updateNumberOfRegimentTroops(ArmyInterface $army, float $modifier)
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
}
