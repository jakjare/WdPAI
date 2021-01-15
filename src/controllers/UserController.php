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
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->messages["userMenu"] = $this->userMenu;
        $this->userRepository = new UserRepository();
    }

    public function users()
    {
        $users = $this->userRepository->getUsers();
        $this->messages['users'] = $users;
        $this->render('users', $this->messages);
    }

    public function addUser()
    {
        if (!$this->isPost() || !isset($_POST['email']))
        {
            return $this->render('users', $this->messages);
        }

        if ($this->userRepository->userExists($_POST['email']))
        {
            $this->messages['messages'] = ["User with this email already exists!"];
            return $this->users();
        }

        $user = new User(
            0,
            $_POST['email'],
            $_POST['new-password'],
            true,
            null,
            $_POST['name'],
            $_POST['surname'],
            $_POST['phone'],
            null,
            $_POST['role'],
            null);

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
    public function settings() {
        session_start();
        $user = $this->userRepository->getUser($_SESSION['email']);

        if (isset($_POST['name']))
        {
            if (!$this->isPost())
            {
                return $this->render('settings', $this->messages);
            }
            if ($this->userRepository->userExists($_POST['email']) && $_POST['email'] != "")
            {
                $this->messages['messages'] = ["User with this email already exists!"];
            }
            else {
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
        }

        $this->messages['name'] = $user->getName();
        $this->messages['surname'] = $user->getSurname();
        $this->messages['email'] = $user->getEmail();
        $this->messages['phone'] = $user->getPhone();
        $this->messages['password'] = $user->getPassword();
        $this->render('settings', $this->messages);
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

            return $this->render('settings', $this->messages);
        }
        $this->messages['messages'] = ['Something went wrong!'];
        $this->render('settings', $this->messages);
    }

    public function getUserJSON(): void
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

    public function changeUserStatusJSON(): void
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            $user = $this->userRepository->getUser($decoded['email']);
            $user->changeStatus();

            $this->userRepository->changePersonalDetails($user);

            echo json_encode($user->isEnabled());
        }
    }

    public function deleteUserJSON(): void
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            $user = $this->userRepository->getUser($decoded['email']);
            $this->userRepository->deleteUser($user);

            echo json_encode($user->isEnabled());
        }
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
}