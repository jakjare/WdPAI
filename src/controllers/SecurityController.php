<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController
{
    public function login()
    {
        $userRepository = new UserRepository();

        if(!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = $userRepository->getUser($email);

        if(!$user) {
            return $this->render('login', ['messages' => ["User not exist!"]]);
        }

        if ($user->getEmail() !== $email) {
            return $this->render('login', ['messages' => ["Wrog username!"]]);
        }

        if ($user->getPassword() !== $password) {
            $userRepository->userLogin($user->getIdDatabase(), false);
            return $this->render('login', ['messages' => ["Wrong password!"]]);
        }

        session_start();
        $_SESSION['email'] = $user->getEmail();
        $_SESSION['name'] = $user->getName();
        $_SESSION['surname'] = $user->getSurname();
        $_SESSION['image'] = $user->getImage();

        $userRepository->userLogin($user->getIdDatabase(), true);

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/dashboard");
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        $this->render('login');
    }

    public function changePassword()
    {
        $userRepository = new UserRepository();
        session_start();
        $email = $_SESSION['email'];
        $user = $userRepository->getUser($email);

        $old_password = $user->getPassword();
        $current_password = $_POST['current-password'];
        $new_password = $_POST['new-password'];
        $confirmed_password = $_POST['confirm-password'];

        if ($old_password !== $current_password)
        {
            return $this->render('settings', ['messages' => ["Old password is incorrect!"]]);
        }
        if ($confirmed_password !== $new_password)
        {
            return $this->render('settings', ['messages' => ["Passwords are different!"]]);
        }

        $user->setPassword($new_password);
        $userRepository->updatePassword($user);

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/settings");

    }
}