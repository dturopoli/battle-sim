<?php

namespace App\Controller;

use App\Contract\Exception\BattleExceptionInterface;
use App\Contract\Service\ArmyFactoryInterface;
use App\Contract\Service\BattleFactoryInterface;
use App\Contract\Service\BattleSimulatorInterface;
use App\Http\Request\BattleRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BattleController extends BaseController
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

        // Handle invalid arguments
        if ($violations->count()) {
            return $this->render('battle/battle.html.twig', [
                'errors' => $this->formatViolations($violations),
            ]);
        }

        $army1 = $this->armyBuilder->create('Army 1', $request->getArmy1());
        $army2 = $this->armyBuilder->create('Army 2', $request->getArmy2());

        $battle = $this->battleFactory->create($army1, $army2);

        try {
            $this->battleSimulator->simulate($battle);
        } catch (BattleExceptionInterface $e) {
            return $this->render('battle/battle.html.twig', [
                'errors' => [$e->getMessage()],
            ]);
        }

        return $this->render('battle/battle.html.twig', [
            'battle_results' => $battle->getBattleResults(),
        ]);
    }
}
