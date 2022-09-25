<?php

namespace App\DependencyInjection;

use App\Model\UnitTypes;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class BattleConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('battle_configuration');

        $rootNode = $treeBuilder->getRootNode();

        $this->addBattleConfiguration($rootNode);

        return $treeBuilder;
    }

    /**
     * Create battle configuration
     * @param ArrayNodeDefinition $rootNode
     */
    private function addBattleConfiguration(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->booleanNode('enable_special_events')
                    ->defaultValue(true)
                ->end()
                ->arrayNode('valid_unit_types')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->scalarPrototype()
                        ->validate()
                        ->ifNotInArray(UnitTypes::validTypes())->thenInvalid(
                            sprintf('Invalid unit type. Valid ones are %s.', implode(', ', UnitTypes::validTypes()))
                        )
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
