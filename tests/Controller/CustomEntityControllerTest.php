<?php

namespace EasyCorp\Bundle\EasyAdminBundle\Tests\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Tests\Fixtures\AbstractTestCase;

class CustomEntityControllerTest extends AbstractTestCase
{
    protected static $options = ['environment' => 'custom_entity_controller'];

    public function testListAction()
    {
        $this->requestListView();
        $this->assertStringContainsString('Overridden list action.', static::$client->getResponse()->getContent());
    }

    public function testShowAction()
    {
        $this->requestShowView();
        $this->assertStringContainsString('Overridden show action.', static::$client->getResponse()->getContent());
    }
}
