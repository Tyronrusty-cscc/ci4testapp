<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Users::index');
$routes->get('users', 'Users::index');
$routes->get('logout', 'Users::logout');
$routes->post('/', 'Users::index');
$routes->match(['get','post'],'register', 'Users::register');
$routes->match(['get','post'],'profile', 'Users::profile',['filter'=>'auth']);
$routes->get('dashboard', 'Dashboard::index',['filter'=>'auth']);

/*new apps route */
$routes->match(['get','post'],'registration','Employee::registration');
$routes->match(['get','post'],'signin','Employee::signin');
$routes->get('account','Employee::myaccount');
$routes->get('employee','Employee::index');
$routes->match(['get','post'],'employee/add','Employee::add');
$routes->match(['get','post'],'employee/save','Employee::save');
$routes->get('employee/edit/(:num)','Employee::edit/$1');
$routes->post('employee/update/(:num)','Employee::update/$1');
$routes->get('employee/delete/(:num)','Employee::delete/$1');