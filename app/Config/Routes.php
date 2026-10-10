<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Pages::index');
$routes->get('home', 'Pages::index');
$routes->get('about', 'Pages::about');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');
$routes->get('signup', 'Auth::signup');
$routes->post('signup', 'Auth::signup');
$routes->post('logout', 'Auth::logout');

$routes->group('', ['filter' => 'auth'], static function ($routes): void {
    $routes->get('customers', 'Customers::index');
    $routes->get('customers/new', 'Customers::newCustomer');
    $routes->post('customers/create', 'Customers::create');
    $routes->get('customers/(:num)/edit', 'Customers::edit/$1');
    $routes->post('customers/(:num)/update', 'Customers::update/$1');
    $routes->post('customers/(:num)/delete', 'Customers::delete/$1');
    $routes->get('users', 'Users::index');
    $routes->get('users/new', 'Users::newUser');
    $routes->post('users/create', 'Users::create');
    $routes->get('users/(:num)/edit', 'Users::edit/$1');
    $routes->post('users/(:num)/update', 'Users::update/$1');
    $routes->post('users/(:num)/delete', 'Users::delete/$1');
});