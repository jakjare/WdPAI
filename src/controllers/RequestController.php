<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Request.php';
require_once __DIR__.'/../models/Device.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/RequestRepository.php';
require_once __DIR__.'/../repository/DeviceRepository.php';
require_once __DIR__.'/../repository/UserRepository.php';

class RequestController extends AppController
{
    private $requestRepository;
    private $deviceRepository;
    private $userRepository;
    private $messages = [];

    public function __construct()
    {
        parent::__construct();
        $this->requestRepository = new RequestRepository();
        $this->deviceRepository = new DeviceRepository();
        $this->userRepository= new UserRepository();
    }

    public function requests()
    {
        session_start();
        $user = $this->userRepository->getUser($_SESSION['email']);
        $requests = $this->requestRepository->getRequestsForUser($user);

        foreach ($requests as $request)
        {
            $sender = $this->userRepository->getUserById($request->getSender());
            $request->setSender($sender);

            if ($request->getDevice() != null)
            {
                $device = $this->deviceRepository->getDeviceById($request->getDevice());
                $request->setDevice($device);
            }
        }

        $this->render('requests', ["requests" => $requests]);
    }

}