<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class UserController extends AppController
{
    const MAX_FILE_SIZE = 1024*1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/users_avatars/';

    private $messages = [];
    private $userReppository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function addAvatar() {

        if($this->isPost() && is_uploaded_file($_FILES['avatar']['tmp_name']) && $this->validate($_FILES['avatar'])) {

            move_uploaded_file(
                $_FILES['avatar']['tmp_name'],
                dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['avatar']['name']
            );

            session_start();
            $this->userRepository->setImage($_SESSION['email'], $_FILES['avatar']['name']);
            $_SESSION['image'] = $_FILES['avatar']['name'];

            return $this->render('settings');
        }
        $this->render('settings', ['messages' => ['Something went wrong!']]);
    }

    private function validate(array $file): bool
    {
        if($file['size'] > self::MAX_FILE_SIZE) {
            $this->messages[] = 'File is too large.';
            return false;
        }

        if(!isset($file['type']) && !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->messages[] = 'File type is not supported.';
            return false;
        }

        return true;
    }

    public function settings() {
        session_start();
        $user = $this->userRepository->getUser($_SESSION['email']);

        if (isset($_POST['name']))
        {
            if (!$this->isPost())
            {
                return $this->render('settings');
            }
            $tmp = $_POST['name'] == "" ? $user->getName() : $_POST['name'];
            $user->setName($tmp);
            $_SESSION['name'] = $tmp;
            $tmp = $_POST['surname'] == "" ? $user->getSurname() : $_POST['surname'];
            $user->setSurname($tmp);
            $_SESSION['surname'] = $tmp;
            $tmp = $_POST['phone'] == "" ? $user->getPhone() : $_POST['phone'];
            $user->setPhone($tmp);

            $tmp = $_POST['email'] == "" ? $user->getEmail() : $_POST['email'];
            $user->setEmail($tmp);
            $_SESSION['email'] = $tmp;


            $this->userRepository->changePersonalDetails($user);
        }

        $this->render('settings', ['name' => $user->getName(), 'surname' => $user->getSurname(), 'email' => $user->getEmail(), 'phone' => $user->getPhone(), 'password' => $user->getPassword()]);
    }

    public function users()
    {
        $users = $this->userRepository->getUsers();
        $this->render('users', ['users' => $users]);
    }

    public function addUser()
    {
        if (!$this->isPost() || !isset($_POST['email']))
        {
            return $this->render('users');
        }

        if ($this->userRepository->userExists($_POST['email']))
        {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/users");
            return $this->render('users', ['messages' => "User with this email already exists!"]);
        }

        $user = new User(
            0,
            $_POST['email'],
            $_POST['new-password'],
            true,
            1234,
            'default',
            $_POST['name'],
            $_POST['surname'],
            $_POST['phone'],
            'default',
            $_POST['role'],
        'null');

        $this->userRepository->newUser($user);

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/users");
    }

    public function editUser()
    {
        if (!$this->isPost() || !isset($_POST['email']))
        {
            $url = "http://$_SERVER[HTTP_HOST]";
            return header("Location: {$url}/users");
        }

        $user = $this->userRepository->getUser($_POST['old-email']);
        $_POST['email'] == $_POST['old-email'] ?: $user->setEmail($_POST['email']);
        $_POST['new-password'] == "" ?: $user->setPassword($_POST['new-password']);
        $_POST['name'] == $user->getName() ?: $user->setName($_POST['name']);
        $_POST['surname'] == $user->getSurname() ?: $user->setSurname($_POST['surname']);
        $_POST['phone'] == $user->getPhone() ?: $user->setPhone($_POST['phone']);
        // TODO ROLE UŻYTKOWNIKA

        $this->userRepository->changePersonalDetails($user);
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/users");
    }

    public function getUserJSON()
    {
        $result = [];
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            $user = $this->userRepository->getUser($decoded['email']);
            $result[] = [
                "id" => $user->getIdDatabase(),
                "email" => $user->getEmail(),
                "name" => $user->getName(),
                "surname" => $user->getSurname(),
                "phone" => $user->getPhone(),
                "role" => $user->getRole()
            ];

            echo json_encode($result);
        }
    }

    public function changeUserStatus()
    {
        //TODO Nie działa!

        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            $user = $this->userRepository->getUser($decoded['email']);
            $user->changeStatus();

            $this->userRepository->changePersonalDetails($user);

        }
    }
}