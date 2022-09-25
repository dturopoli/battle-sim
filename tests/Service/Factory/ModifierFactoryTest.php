<?php

namespace App\Tests\Service\Factory;

use App\Contract\Service\ModifierFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ModifierFactoryTest extends KernelTestCase
{
    public function testCreate()
    {
        self::bootKernel();
        $container = static::getContainer();

        /** @var ModifierFactoryInterface $modifierFactory */
        $modifierFactory = $container->get(ModifierFactoryInterface::class);

        $modifier = $modifierFactory->create('modifier_name', 0.43);

        $this->assertEquals('modifier_name', $modifier->getName());
        $this->assertEquals(0.43, $modifier->getValue());
    }
}
