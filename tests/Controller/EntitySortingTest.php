<?php

namespace EasyCorp\Bundle\EasyAdminBundle\Tests\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Tests\Fixtures\AbstractTestCase;

class EntitySortingTest extends AbstractTestCase
{
    protected static $options = ['environment' => 'entity_sorting'];

    public function testMainMenuSorting()
    {
        $crawler = $this->requestListView('Product');

        $this->assertStringContainsString('sortField=price', $crawler->filter('.sidebar-menu a:contains("Product 1")')->attr('href'));
        $this->assertStringNotContainsString('sortDirection', $crawler->filter('.sidebar-menu a:contains("Product 1")')->attr('href'));
        $this->assertStringContainsString('sortField=price', $crawler->filter('.sidebar-menu a:contains("Product 2")')->attr('href'));
        $this->assertStringContainsString('sortDirection=ASC', $crawler->filter('.sidebar-menu a:contains("Product 2")')->attr('href'));
        $this->assertStringContainsString('sortField=id', $crawler->filter('.sidebar-menu a:contains("Product 3")')->attr('href'));
        $this->assertStringNotContainsString('sortDirection', $crawler->filter('.sidebar-menu a:contains("Product 3")')->attr('href'));

        // click on any menu item to sort contents differently
        $link = $crawler->filter('.sidebar-menu a:contains("Product 2")')->link();
        $crawler = static::$client->click($link);

        $this->assertStringNotContainsString('sorted', $crawler->filter('th:contains("Name")')->attr('class'));
        $this->assertStringContainsString('sorted', $crawler->filter('th:contains("Price")')->attr('class'));
        $this->assertStringContainsString('fa-arrow-up', $crawler->filter('th:contains("Price") i')->attr('class'));
    }

    public function testListViewSorting()
    {
        $crawler = $this->requestListView('Product');

        // check the default sorting of the page
        $this->assertStringContainsString('sorted', $crawler->filter('th:contains("Name")')->attr('class'));
        $this->assertStringContainsString('fa-arrow-down', $crawler->filter('th:contains("Name") i')->attr('class'));

        // click on any other table column to sort contents differently
        $link = $crawler->filter('th:contains("Price") a')->link();
        $crawler = static::$client->click($link);
        $this->assertStringNotContainsString('sorted', $crawler->filter('th:contains("Name")')->attr('class'));
        $this->assertStringContainsString('sorted', $crawler->filter('th:contains("Price")')->attr('class'));
        $this->assertStringContainsString('fa-arrow-down', $crawler->filter('th:contains("Price") i')->attr('class'));
    }

    public function testSearchViewSorting()
    {
        $crawler = $this->requestSearchView('lorem', 'Product');

        // check the default sorting of the page
        $this->assertStringContainsString('sorted', $crawler->filter('th:contains("Created at")')->attr('class'));
        $this->assertStringContainsString('fa-arrow-up', $crawler->filter('th:contains("Created at") i')->attr('class'));

        // click on any other table column to sort contents differently
        $link = $crawler->filter('th:contains("Name") a')->link();
        $crawler = static::$client->click($link);
        $this->assertStringNotContainsString('sorted', $crawler->filter('th:contains("Created at")')->attr('class'));
        $this->assertStringContainsString('sorted', $crawler->filter('th:contains("Name")')->attr('class'));
        $this->assertStringContainsString('fa-arrow-down', $crawler->filter('th:contains("Name") i')->attr('class'));
    }
}
