<?php

namespace Fm\PaymentPaymillBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        return $treeBuilder
            ->root('fm_payment_paymill', 'array')
                ->children()
                    ->scalarNode('api_private_key')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('api_public_key')->isRequired()->cannotBeEmpty()->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
