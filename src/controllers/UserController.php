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
}