<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('nosotros', 'Nosotros::index');

// Admin Auth (sin filtro)
$routes->get('admin/login',  'Admin\Auth::login');
$routes->post('admin/login', 'Admin\Auth::doLogin');
$routes->get('admin/logout', 'Admin\Auth::logout');

// Admin Panel (protegido)
$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get('/',                          'Admin\Dashboard::index');
    $routes->get('dashboard',                  'Admin\Dashboard::index');
    $routes->get('productos',                  'Admin\Productos::index');
    $routes->get('productos/crear',            'Admin\Productos::crear');
    $routes->post('productos/crear',           'Admin\Productos::guardar');
    $routes->get('productos/(:num)/editar',    'Admin\Productos::editar/$1');
    $routes->post('productos/(:num)/editar',   'Admin\Productos::actualizar/$1');
    $routes->post('productos/(:num)/eliminar',  'Admin\Productos::eliminar/$1');
    $routes->post('productos/(:num)/destacado', 'Admin\Productos::toggleDestacado/$1');

    $routes->get('consultas',                          'Admin\Consultas::index');
    $routes->post('consultas/(:num)/vista',            'Admin\Consultas::marcarVista/$1');
    $routes->post('consultas/(:num)/resuelta',         'Admin\Consultas::marcarResuelta/$1');

    // Categorías
    $routes->get('categorias',                         'Admin\Categorias::index');
    $routes->get('categorias/crear',                   'Admin\Categorias::crear');
    $routes->post('categorias/crear',                  'Admin\Categorias::guardar');
    $routes->get('categorias/(:num)/editar',           'Admin\Categorias::editar/$1');
    $routes->post('categorias/(:num)/editar',          'Admin\Categorias::actualizar/$1');
    $routes->post('categorias/(:num)/eliminar',        'Admin\Categorias::eliminar/$1');
    $routes->post('categorias/(:num)/toggle',          'Admin\Categorias::toggleActivo/$1');

    // Marcas
    $routes->get('marcas',                             'Admin\Marcas::index');
    $routes->get('marcas/crear',                       'Admin\Marcas::crear');
    $routes->post('marcas/crear',                      'Admin\Marcas::guardar');
    $routes->get('marcas/(:num)/editar',               'Admin\Marcas::editar/$1');
    $routes->post('marcas/(:num)/editar',              'Admin\Marcas::actualizar/$1');
    $routes->post('marcas/(:num)/eliminar',            'Admin\Marcas::eliminar/$1');
});

$routes->get('servicio-tecnico', 'ServicioTecnico::index');
$routes->post('consultas/guardar', 'ConsultaServicio::guardar');

$routes->get('contacto', 'Contacto::index');
$routes->post('contacto', 'Contacto::enviar');

$routes->get('catalogo/buscar', 'Catalogo::buscar');
$routes->get('catalogo/(:segment)/(:segment)/(:segment)', 'Catalogo::browse/$1/$2/$3');
$routes->get('catalogo/(:segment)/(:segment)', 'Catalogo::browse/$1/$2');
$routes->get('catalogo/(:segment)', 'Catalogo::browse/$1');
$routes->get('catalogo', 'Catalogo::index');
