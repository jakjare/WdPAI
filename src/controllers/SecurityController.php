<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController
{
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function login()
    {
        if(!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = $this->userRepository->getUser($email);

        if(!$user) {
            return $this->render('login', ['messages' => ["User not exist!"]]);
        }

        if ($user->getEmail() !== $email) {
            return $this->render('login', ['messages' => ["Wrog username!"]]);
        }

        if (!password_verify($password, $user->getPassword())) {
            $this->userRepository->userLogin($user->getIdDatabase(), false);
            return $this->render('login', ['messages' => ["Wrong password!"]]);
        }

        $_SESSION['email'] = $user->getEmail();
        $_SESSION['name'] = $user->getName();
        $_SESSION['surname'] = $user->getSurname();
        $_SESSION['image'] = $user->getImage();

        $this->userRepository->userLogin($user->getIdDatabase(), true);
        $this->userRepository->setSession($user->getIdDatabase());

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/dashboard");
    }

    public function logout()
    {
        $this->permissionRepository->deleteSession();
        session_start();
        session_unset();
        session_destroy();
        $this->render('login');
    }

    public function changePassword()
    {
        session_start();
        $email = $_SESSION['email'];
        $user = $this->userRepository->getUser($email);

        $old_password = $user->getPassword();
        $current_password = $_POST['current-password'];
        $new_password = $_POST['new-password'];
        $confirmed_password = $_POST['confirm-password'];

        if (!password_verify($current_password, $old_password))
        {
            return $this->render('settings', ['messages' => ["Old password is incorrect!"]]);
        }
        if ($confirmed_password !== $new_password)
        {
            return $this->render('settings', ['messages' => ["Passwords are different!"]]);
        }

        $user->setPassword(password_hash($new_password, PASSWORD_DEFAULT));
        $this->userRepository->updatePassword($user);

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/settings");

    }
}