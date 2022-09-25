<?php

namespace App\Controller;

use App\Contract\Service\ArmyFactoryInterface;
use App\Contract\Service\BattleFactoryInterface;
use App\Contract\Service\BattleSimulatorInterface;
use App\Http\Request\BattleRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BattleController extends AbstractController
{
    /**
     * @param ArmyFactoryInterface $armyBuilder
     * @param BattleSimulatorInterface $battleSimulator
     * @param BattleFactoryInterface $battleFactory
     */
    public function __construct(
        private ArmyFactoryInterface $armyBuilder,
        private BattleSimulatorInterface $battleSimulator,
        private BattleFactoryInterface $battleFactory
    ) {
    }

    #[Route('/battle-simulator', name: 'battle_simulator', methods: 'GET')]
    public function battleAction(BattleRequest $request): Response
    {
        $violations = $request->validate();

        if ($violations->count()) {
            return $this->render('battle/battle.html.twig', [
                'errors' => $violations
            ]);
        }

        $army1 = $this->armyBuilder->create('Army 1', $request->getArmy1());
        $army2 = $this->armyBuilder->create('Army 2', $request->getArmy2());

        $battle = $this->battleFactory->create($army1, $army2);

        $this->battleSimulator->simulate($battle);

        return $this->render('battle/battle.html.twig', [
            'battle_results' => $battle->getBattleResults(),
        ]);
    }
}
