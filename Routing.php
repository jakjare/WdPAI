<?php

require_once 'src/controllers/AppController.php';
require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/UserController.php';
require_once 'src/controllers/DeviceController.php';
require_once 'src/controllers/RequestController.php';
require_once 'src/controllers/AdministrationController.php';

class Routing {
    public static $routes;

    public static function get($url, $controller) {
        self::$routes[$url] = $controller;
    }

    public static function post($url, $controller) {
        self::$routes[$url] = $controller;
    }

    public static function run($url) {
        $appController = new AppController();
        $pages = $appController->getPages();

        foreach ($pages as $page)
        {
            if ($page['method'] == null) {
                break;
            }
            $method = $page['method'];
            self::$method($page['url'], $page['controller']);
        }
        $action = explode("/", $url)[0];

        if(!array_key_exists($action, self::$routes)) {
            $action = 'error';
        }

        $controller = self::$routes[$action];
        $object = new $controller;
        $action = $action ?: 'index';

        $object->$action();
    }
}