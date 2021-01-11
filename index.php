<?php

require_once 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('', 'DefaultController');
Routing::get('index', 'DefaultController');
Routing::get('dashboard', 'DefaultController');
Routing::get('devices', 'DeviceController');
Routing::get('addDevice', 'DeviceController');
Routing::get('addLocation', 'DeviceController');
Routing::get('users', 'UserController');
Routing::get('error', 'DefaultController');
Routing::post('settings', 'UserController');
Routing::post('login', 'SecurityController');
Routing::post('logout', 'SecurityController');
Routing::post('addAvatar', 'UserController');
Routing::post('addUser', 'UserController');
Routing::post('editUser', 'UserController');
Routing::post('getUserJSON', 'UserController');
Routing::post('changeUserStatusJSON', 'UserController');
Routing::post('deleteUserJSON', 'UserController');
Routing::post('changePassword', 'SecurityController');

Routing::run($path);
