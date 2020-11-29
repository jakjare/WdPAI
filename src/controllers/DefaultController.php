<?php

require_once 'AppController.php';

class DefaultController extends AppController {

    public function index() {
        // TODO display login.html
        $this->render('login');
    }

    public function dashboard() {
        // TODO display dashboard.html
        $this->render('dashboard');
    }

}