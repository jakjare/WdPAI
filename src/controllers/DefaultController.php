<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../models/Problem.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/DeviceRepository.php';
require_once __DIR__.'/../repository/ProblemRepository.php';

class DefaultController extends AppController
{
    private $userRepository;
    private $deviceRepository;
    private $problemRepository;
    private $messages = [];

    public function __construct()
    {
        parent::__construct();
        $this->messages["userMenu"] = $this->userMenu;
        $this->userRepository = new UserRepository();
        $this->deviceRepository = new DeviceRepository();
        $this->problemRepository = new ProblemRepository();
    }
    public function index()
    {
        $this->render('login');
    }

    public function error()
    {
        $this->render('error');
    }

    public function dashboard()
    {
        session_start();
        $users = $this->userRepository->getUsers();
        $me = $this->userRepository->getUser($_SESSION['email']);
        $problems = $me->getRole() == "administrator" ? $this->problemRepository->getAdminProblems($me) : $this->problemRepository->getUserProblems($me);
        foreach ($problems as $problem)
        {
            $duration = explode(';', $problem->getDuration());
            $duration = $duration[0]."days ".$duration[1]."h ".$duration[2]."min ".$duration[3]."s";
            $problem->setDuration($duration);
        }

        $users_online = $this->userRepository->getOnlineStats();
        $devices_online = $this->deviceRepository->getOnlineStats();

        $this->messages["users"] = $users;
        $this->messages["problems"] = $problems;
        $this->messages["users_online"] = $users_online;
        $this->messages["devices_online"] = $devices_online;

        $this->render('dashboard', $this->messages);
    }
}