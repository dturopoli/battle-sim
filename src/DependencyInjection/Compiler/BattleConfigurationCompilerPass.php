<?php

namespace App\DependencyInjection\Compiler;

use App\Contract\Service\ArmyFactoryInterface;
use App\Contract\Service\BattleSimulatorInterface;
use App\DependencyInjection\BattleConfiguration;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Yaml;

class BattleConfigurationCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $processor = new Processor();

        // Process BattleConfiguration
        $config = Yaml::parse(file_get_contents(__DIR__.'/../../../config/battle_configuration.yaml'));
        $config = $processor->processConfiguration(new BattleConfiguration(), $config);

        $armyFactory = $container->getDefinition(ArmyFactoryInterface::class);
        $armyFactory->setArgument('$validUnitTypes', $config['valid_unit_types']);

        $battleSimulator = $container->getDefinition(BattleSimulatorInterface::class);
        $battleSimulator->setArgument('$enableSpecialEvents', boolval($config['enable_special_events']));
    }
}
