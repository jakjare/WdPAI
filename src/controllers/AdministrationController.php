<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/Request.php';
require_once __DIR__.'/../models/Device.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../models/Problem.php';
require_once __DIR__.'/../repository/RequestRepository.php';
require_once __DIR__.'/../repository/DeviceRepository.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/ProblemRepository.php';

class AdministrationController extends AppController
{
    private $requestRepository;
    private $problemRepository;
    private $deviceRepository;
    private $userRepository;
    private $me;
    private $messages = [];

    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->messages["userMenu"] = $this->userMenu;
        $this->requestRepository = new RequestRepository();
        $this->deviceRepository = new DeviceRepository();
        $this->userRepository= new UserRepository();
        $this->problemRepository= new ProblemRepository();
        $this->me = $this->userRepository->getUser($_SESSION['email']);
    }

    public function administration()
    {
        $problems = $this->problemRepository->getAdminProblems($this->me);
        $statuses = $this->problemRepository->getProblemStatuses();

        foreach ($problems as $problem)
        {
            $this->makeProblem($problem);
        }

        $this->messages["problems"] = $problems;
        $this->messages["statuses"] = $statuses;
        $this->render('administration', $this->messages);
    }

    public function replyProblem()
    {
        if (!$this->isPost() || !isset($_POST['id']))
        {
            return $this->administration();
        }

        $this->problemRepository->setProblemAckUser($_POST['id'], $this->me->getIdDatabase());
        $this->problemRepository->setProblemStatus($_POST['id'], $_POST['status']);
        $problem = $this->problemRepository->getProblemById($_POST['id']);
        $this->makeProblem($problem);
        $request = new Request(
            0,
            $problem->getAckUser()->getIdDatabase(),
            intval($problem->getDevice()->getId()),
            '[PROBLEM: '.$problem->getDevice()->getName().' STATUS: '.strtoupper($problem->getProblemStatus()).']',
            $_POST['content']
        );

        $this->requestRepository->addRequest($request, [0 => $problem->getReportingUser()->getIdDatabase()]);

        $this->administration();
    }

    public function newProblem()
    {
        $devices = $this->deviceRepository->getUserDevices($this->me);
        $this->messages["devices"] = $devices;

        $this->render('newProblem', $this->messages);
    }

    public function addProblem()
    {
        if (!$this->isPost() || !isset($_POST['description']))
        {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/newProblem");
        }

        $problem = new Problem(
            0,
            null,
            null,
            $this->me->getIdDatabase(),
            $_POST['id_device'],
            $_POST['description'],
            0,
            0
        );

        $this->problemRepository->addProblem($problem);

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/newProblem");
    }

    public function getSpecificProblemJSON()
    {
        $result = [];
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            $problem = $this->problemRepository->getProblemById(intval($decoded['id']));
            $device = $this->deviceRepository->getDeviceById($problem->getDevice());
            $permissionsIdUsers = $this->deviceRepository->getPermissionIdUsers($device->getId());

            $permissionsUsers = [];
            foreach ($permissionsIdUsers as $permissionsIdUser)
            {
                $user = $this->userRepository->getUserById($permissionsIdUser['id_user']);
                $permissionsUsers[] = new ArrayObject([
                    "name" => $user->getName(),
                    "surname" => $user->getSurname(),
                    "email" => $user->getEmail()
                ]);
            }

            $problems_form_repository = $this->problemRepository->getProblemsByDeviceId($device->getId());
            foreach ($problems_form_repository as $problem_from_repository)
            {
                $this->makeProblem($problem_from_repository);
                $problem_history[] = new ArrayObject([
                    "id" => $problem_from_repository->getId(),
                    "status" => $problem_from_repository->getProblemStatus(),
                    "description" => $problem_from_repository->getDescription(),
                    "time" => $problem_from_repository->getDate(),
                    "ack" => $problem_from_repository->getAckUser() == null ? 'No' : $problem_from_repository->getAckUser()->getName().' '.$problem_from_repository->getAckUser()->getSurname(),
                    "reported" => $problem_from_repository->getReportingUser()->getName().' '.$problem_from_repository->getReportingUser()->getSurname()
                ]);
            }

            $result[] = [
                "id_device" => $device->getId(),
                "state" => $device->getOperationStatus(),
                "ip_address" => $device->getIpAddress(),
                "comment" => $device->getComment(),
                "permissions" => $permissionsUsers,
                "problem_history" => $problem_history
            ];

            echo json_encode($result);
        }
    }

    public function setAckJSON()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            $this->problemRepository->setProblemAckUser(intval($decoded['id_problem']), $this->me->getIdDatabase());
            $this->problemRepository->setProblemStatus(intval($decoded['id_problem']), 4);
        }
    }

    private function makeProblem(Problem $problem): void
    {
        if ($problem->getAckUser() != null)
        {
            $user = $this->userRepository->getUserById($problem->getAckUser());
            $problem->setAckUser($user);
        }
        $reporting_user = $this->userRepository->getUserById($problem->getReportingUser());
        $problem->setReportingUser($reporting_user);
        $device = $this->deviceRepository->getDeviceById($problem->getDevice());
        $problem->setDevice($device);
        $duration = $problem->getDuration();
        $duration = explode(';', $duration);
        $duration = $duration[0]."days ".$duration[1]."h ".$duration[2]."min ".$duration[3]."s";
        $problem->setDuration($duration);
    }
}