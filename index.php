<?php

require_once 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('', 'DefaultController');
Routing::get('index', 'DefaultController');
Routing::get('dashboard', 'DefaultController');
Routing::get('devices', 'DefaultController');
Routing::get('users', 'UserController');
Routing::get('error', 'DefaultController');
Routing::post('settings', 'UserController');
Routing::post('login', 'SecurityController');
Routing::post('logout', 'SecurityController');
Routing::post('addAvatar', 'UserController');
Routing::post('changePassword', 'SecurityController');

Routing::run($path);
