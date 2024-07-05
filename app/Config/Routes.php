<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'DataSLAController::index'); // Redirect to login page
$routes->get('/login', 'UserController::login'); // Login page
$routes->post('/processLogin', 'UserController::processLogin'); // Handle login form submission
$routes->get('/logout', 'UserController::logout'); // Logout
$routes->group('', ['filter' => 'auth'], function ($routes) {
// $routes->get('/', 'Home::index');
$routes->get('/', 'DataSLAController::index');
$routes->post('/chart', 'ChartController::index');
$routes->group('', ['filter' => 'role'], function ($routes) {
$routes->post('/users/add', 'UserController::add');
$routes->get('/users', 'UserController::index');
$routes->post('/users/edit/(:num)', 'UserController::edit/$1');
$routes->get('/users/delete/(:num)', 'UserController::delete/$1');
});

$routes->get('/hub', 'HubController::index'); // Maps the index method of Hub controller to the /hub URL
$routes->post('/hub/add', 'HubController::add'); // Maps the add method of Hub controller to the /hub/add URL
$routes->get('/hub/export', 'HubController::export');
$routes->get('/hub/exportcsv', 'HubController::exportcsv');
$routes->post('/hub/import', 'HubController::import');
$routes->post('/hub/edit/(:num)', 'HubController::edit/$1'); // Maps the edit method of Hub controller to the /hub/edit/{id} URL
$routes->post('hub/delete/(:num)', 'HubController::delete/$1'); // Maps the delete method of Hub controller to the /hub/delete/{id} URL
});