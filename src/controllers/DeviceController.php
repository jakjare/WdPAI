<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Device.php';
require_once __DIR__.'/../models/Location.php';
require_once __DIR__.'/../models/OperationStatus.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/DeviceRepository.php';
require_once __DIR__.'/../repository/LocationRepository.php';
require_once __DIR__.'/../repository/UserRepository.php';

class DeviceController extends AppController
{
    private $deviceRepository;
    private $locationRepository;
    private $userRepository;
    private $messages = [];

    public function __construct()
    {
        parent::__construct();
        $this->messages["userMenu"] = $this->userMenu;
        $this->deviceRepository = new DeviceRepository();
        $this->locationRepository= new LocationRepository();
        $this->userRepository= new UserRepository();
    }

    public function devices() {
        $devices = $this->deviceRepository->getDeviceList();
        $locations = $this->locationRepository->getLocations();
        $users = $this->userRepository->getUsersByRole('user');

        $this->messages["devices"] = $devices;
        $this->messages["locations"] = $locations;
        $this->messages["users"] = $users;
        $this->render('devices', $this->messages);
    }

    public function addDevice() {
        if (!$this->isPost() || !isset($_POST['name']))
        {
            return $this->render('devices', $this->messages);
        }
        $device = new Device(
            0,
            $_POST['name'],
            $_POST['comment'],
            $_POST['ip'],
            $_POST['location'],
            0,
            '',
            true
        );
        $permission = $_POST['permission'];
        $this->deviceRepository->addDevice($device, $permission);

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/devices");
    }

    public function addLocation() {
        if (!$this->isPost() || !isset($_POST['name']))
        {
            return $this->render('devices', $this->messages);
        }

        $location = new Location(0, $_POST['name']);
        $this->locationRepository->addLocation($location);

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/devices");
    }

    public function revokePermissionJSON()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            $user = $this->userRepository->getUser($decoded['email']);
            $this->deviceRepository->revokePermission($user->getIdDatabase(), intval($decoded['id_device']));
        }
    }
}