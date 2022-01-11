<?php

namespace EasyCorp\Bundle\EasyAdminBundle\Tests\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Tests\Fixtures\AbstractTestCase;

class EntitySortingByAssociationTest extends AbstractTestCase
{
    protected static $options = ['environment' => 'entity_sorting_by_association'];

    public function testListViewSorting()
    {
        $crawler = $this->requestListView();

        $this->assertStringContainsString('sorted', $crawler->filter('th:contains("Parent")')->attr('class'));
        $this->assertStringContainsString('fa-arrow-down', $crawler->filter('th:contains("Parent") i')->attr('class'));
    }

    public function testSearchViewSorting()
    {
        $crawler = $this->requestSearchView();

        $this->assertStringContainsString('sorted', $crawler->filter('th:contains("Parent")')->attr('class'));
        $this->assertStringContainsString('fa-arrow-up', $crawler->filter('th:contains("Parent") i')->attr('class'));
    }
}
