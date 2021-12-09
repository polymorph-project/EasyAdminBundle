<?php

namespace EasyCorp\Bundle\EasyAdminBundle\Tests\DependencyInjection\Compiler;

use EasyCorp\Bundle\EasyAdminBundle\Configuration\ActionConfigPass;
use PHPUnit\Framework\TestCase;

class ActionConfigPassTest extends TestCase
{
    /**
     * @dataProvider getWrongActionConfigs
     */
    public function testActionconfigFormat($actionsConfig): void
    {
        $this->expectExceptionMessage("One of the actions defined by the global \"list\" view defined under \"easy_admin\" option contains an invalid value (action config can only be a YAML string or hash).");
        $this->expectException(\RuntimeException::class);
        $configPass = new ActionConfigPass();
        $method = new \ReflectionMethod($configPass, 'doNormalizeActionsConfig');
        $method->setAccessible(true);

        $method->invoke($configPass, $actionsConfig, 'the global "list" view defined under "easy_admin" option');
    }

    public function getWrongActionConfigs(): array
    {
        return [
            [[7]],
            [[true]],
            [[null]],
        ];
    }
}
