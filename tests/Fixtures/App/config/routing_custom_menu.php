<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$easyAdminBundleRoutes = $loader->import('@EasyAdminBundle/Controller/EasyAdminController.php', 'annotation');
$easyAdminBundleRoutes->addPrefix('/admin/');
$routes->addCollection($easyAdminBundleRoutes);

$routes->add('custom_route', new Route(
    '/custom-route',
    [
        '_controller' => 'Symfony\Bundle\FrameworkBundle\Controller\TemplateController::templateAction',
        'template' => 'custom_menu/template.html.twig',
    ]
));

return $routes;
