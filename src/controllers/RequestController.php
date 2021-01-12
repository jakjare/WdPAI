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

    public function requests($archived = false)
    {
        session_start();
        $user = $this->userRepository->getUser($_SESSION['email']);
        $requests = $this->requestRepository->getRequestsForUser($user, $archived);

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

        $this->render('requests', ["requests" => $requests, "archived" => $archived]);
    }

    public function archiveRequests()
    {
        $this->requests(true);
    }

    public function newRequest()
    {
        session_start();
        $users = $this->userRepository->getUsers();
        $me = $this->userRepository->getUser($_SESSION['email']);
        $devices = $this->deviceRepository->getUserDevices($me);

        $this->messages["users"] = $users;
        $this->messages["devices"] = $devices;
        $this->render('newRequest', $this->messages);
    }

    public function addRequest()
    {
        if (!$this->isPost() || !isset($_POST['topic']))
        {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/requests");
        }
        if (!isset($_POST['id_receivers']))
        {
            $this->messages["message"] = "No receivers were selected!";
            return $this->newRequest();
        }
        session_start();
        $user = $this->userRepository->getUser($_SESSION['email']);


        $request = new Request(
            0,
            $user->getIdDatabase(),
            intval($_POST['device']),
            $_POST['topic'],
            $_POST['content']
        );

        $this->requestRepository->addRequest($request, $_POST['id_receivers']);

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/requests");
    }

    public function getRequestJSON()
    {
        $result = [];
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            $request = $this->requestRepository->getRequestById(intval($decoded['id']));
            $sender = $this->userRepository->getUserById($request->getSender());

            $device = $request->getDevice() == null ? null : $this->deviceRepository->getDeviceById($request->getDevice());
            $id_device = $device == null ? '' : $device->getId();
            $device_name = $device == null ? 'no device' : $device->getName();

            $result[] = [
                "topic" => $request->getTopic(),
                "from" => $sender->getName().' '.$sender->getSurname(),
                "date" => $request->getTime(),
                "id_device" => $id_device,
                "device" => $device_name,
                "content" => $request->getContent()
            ];

            echo json_encode($result);
        }
    }

    public function changeRequestArchivedJSON()
    {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        header('Content-type: application/json');
        http_response_code(200);

        $this->requestRepository->changeArchivedStatus(intval($decoded['id']));
    }
}