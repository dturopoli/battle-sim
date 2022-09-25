<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use App\DependencyInjection\Compiler\BattleConfigurationCompilerPass;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new BattleConfigurationCompilerPass());

        parent::build($container);
    }
}
