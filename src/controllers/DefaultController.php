<?php

require_once 'AppController.php';

class DefaultController extends AppController {

    public function menu() {
        echo "<ul>
                <li>
                    <a href=\"dashboard\" alt='dashboard'>
                        <i class=\"fas fa-house-user\"></i>
                        <div>Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href=\"administration\" alt='administration'>
                        <i class=\"fas fa-clipboard-list\"></i>
                        <div>Administration</div>
                    </a>
                </li>
                <li>
                    <a href=\"users\" alt='users'>
                        <i class=\"fas fa-users-cog\"></i>
                        <div>Users</div>
                    </a>
                </li>
                <li>
                    <a href=\"devices\" alt='devices'>
                        <i class=\"fas fa-server\"></i>
                        <div>Devices</div>
                    </a>
                </li>
                <li>
                    <a href=\"requests\" alt='requests'>
                        <i class=\"far fa-envelope\"></i>
                        <div>Requests</div>
                    </a>
                </li>
            </ul>";
    }

    public function header() {
        echo "<a href=\"dashboard\"><img src=\"public/img/icon_admingate.svg\"></a>
            <a href=\"#\" class=\"push\"><i class=\"far fa-bell\"></i></a>
            <a href=\"#\"><i class=\"fas fa-cog\"></i></a>
            <div class=\"user-header\">
                <p>username@email.com</p>
                <p>organization name</p>
            </div>
            <div class=\"avatar\"></div>";
    }

    public function index() {
        // TODO display login.php
        $this->render('login');
    }

    public function dashboard() {
        // TODO display dashboard.php
        $this->render('dashboard');
    }

    public function devices() {
        // TODO display devices.php
        $this->render('devices');
    }

    public function users() {
        // TODO display users.php
        $this->render('users');
    }

    public function error() {
        // TODO display error.php
        $this->render('error');
    }

}