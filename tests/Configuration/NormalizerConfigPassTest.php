<?php

namespace EasyCorp\Bundle\EasyAdminBundle\Tests\DependencyInjection\Compiler;

use EasyCorp\Bundle\EasyAdminBundle\Configuration\NormalizerConfigPass;
use EasyCorp\Bundle\EasyAdminBundle\Form\Filter\FilterRegistry;
use PHPUnit\Framework\TestCase;

class NormalizerConfigPassTest extends TestCase
{
    public function testFieldsMustBeStringsOrArrays(): void
    {
        $this->expectExceptionMessage("The values of the \"fields\" option for the \"edit\" view of the \"AppBundle\Entity\TestEntity\" entity can only be strings or arrays.");
        $this->expectException(\RuntimeException::class);
        $backendConfig = ['entities' => [
            'TestEntity' => [
                'class' => 'AppBundle\Entity\TestEntity',
                'edit' => [
                    'fields' => [20],
                ],
            ],
        ]];

        $configPass = new NormalizerConfigPass($this->getServiceContainer(), $this->getFilterRegistry());
        $configPass->process($backendConfig);
    }

    public function testFieldsMustDefinePropertyOption(): void
    {
        $this->expectExceptionMessage("One of the values of the \"fields\" option for the \"edit\" view of the \"AppBundle\Entity\TestEntity\" entity does not define neither of the mandatory options (\"property\" or \"type\").");
        $this->expectException(\RuntimeException::class);
        $backendConfig = ['entities' => [
            'TestEntity' => [
                'class' => 'AppBundle\Entity\TestEntity',
                'edit' => [
                    'fields' => [
                        ['label' => 'Field without "property" option'],
                    ],
                ],
            ],
        ]];

        $configPass = new NormalizerConfigPass($this->getServiceContainer(), $this->getFilterRegistry());
        $configPass->process($backendConfig);
    }

    private function getServiceContainer()
    {
        return $this->getMockBuilder('Symfony\Component\DependencyInjection\Container')
            ->disableOriginalConstructor()
            ->getMock();
    }

    private function getFilterRegistry()
    {
        $filterRegistry = $this->getMockBuilder(FilterRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();

        return $filterRegistry;
    }
}
