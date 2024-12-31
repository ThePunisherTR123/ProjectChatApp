<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// app/Config/Routes.php

$routes->get('/', 'Home::index'); // Ana sayfa için rota
$routes->get('/register', 'AuthController::register'); // Kayıt sayfası
$routes->post('/register_process', 'AuthController::register_process'); // Kayıt işlemi
$routes->post('/login_process', 'AuthController::login_process'); // Giriş işlemi
$routes->get('auth/logout', 'AuthController::logout'); // Çıkış yapma
$routes->post('/save_message', 'MessageController::saveMessage');
$routes->get('/fetch_messages', 'MessageController::fetchMessages');

// Admin İşlemleri
$routes->group('admin', ['filter' => 'auth'], function($routes) {  // Burada 'auth' kullanarak genel filtreyi uyguluyoruz
    $routes->get('users', 'AdminController::users');
    $routes->get('messages', 'AdminController::messages');
    $routes->get('add_user', 'AdminController::addUser');
    $routes->post('create_user', 'AdminController::create_user');
    $routes->get('add_message', 'AdminController::addMessage');
    $routes->post('create_message', 'AdminController::createMessage');
    $routes->get('delete_user/(:num)', 'AdminController::deleteUser/$1');
    $routes->get('edit_user/(:num)', 'AdminController::editUser/$1');
    $routes->post('update_user/(:num)', 'AdminController::updateUser/$1');


    $routes->get('delete_message/(:num)', 'AdminController::deleteMessage/$1');
    $routes->get('/', 'AdminController::index');

    $routes->get('alert', 'ErrorController::alertWithRedirect');


});
