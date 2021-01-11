<?php

require_once 'AppController.php';

class DefaultController extends AppController {

    public function index() {
        // TODO display login.php
        $this->render('login');
    }

    public function dashboard() {
        // TODO display dashboard.php
        $this->render('dashboard');
    }

    public function error() {
        // TODO display error.php
        $this->render('error');
    }

}