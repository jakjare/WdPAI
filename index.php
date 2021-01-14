<?php

require_once 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('', 'DefaultController');
Routing::get('index', 'DefaultController');
Routing::get('error', 'DefaultController');
Routing::post('login', 'SecurityController');

/*
Routing::get('dashboard', 'DefaultController');


Routing::post('logout', 'SecurityController');
Routing::post('changePassword', 'SecurityController');

Routing::get('devices', 'DeviceController');
Routing::get('addDevice', 'DeviceController');
Routing::get('addLocation', 'DeviceController');
Routing::post('revokePermissionJSON', 'DeviceController');

Routing::get('users', 'UserController');
Routing::post('settings', 'UserController');
Routing::post('addAvatar', 'UserController');
Routing::post('addUser', 'UserController');
Routing::post('editUser', 'UserController');
Routing::post('getUserJSON', 'UserController');
Routing::post('changeUserStatusJSON', 'UserController');
Routing::post('deleteUserJSON', 'UserController');

Routing::get('newRequest', 'RequestController');
Routing::get('requests', 'RequestController');
Routing::get('archiveRequests', 'RequestController');
Routing::post('addRequest', 'RequestController');
Routing::post('getRequestJSON', 'RequestController');
Routing::post('changeRequestArchivedJSON', 'RequestController');

Routing::get('administration', 'AdministrationController');
Routing::get('newProblem', 'AdministrationController');
Routing::post('addProblem', 'AdministrationController');
Routing::post('replyProblem', 'AdministrationController');
Routing::post('getSpecificProblemJSON', 'AdministrationController');
Routing::post('setAckJSON', 'AdministrationController');
*/
Routing::run($path);
