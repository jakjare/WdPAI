<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $email): ?User
    {
        $stmt =$this->database->connect()->prepare('
            SELECT * FROM public.users WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
            //TODO zamiast zwracać nulla należy zwracać exception
        }

        $stmt =$this->database->connect()->prepare('
            SELECT * FROM public.user_details WHERE id = :id_user_details
        ');
        $stmt->bindParam(':id_user_details', $user['id_user_details'], PDO::PARAM_STR);
        $stmt->execute();
        $user_details = $stmt->fetch(PDO::FETCH_ASSOC);

        return new User(
            $user['id'],
            $user['email'],
            $user['password'],
            $user['enabled'],
            $user['salt'],
            $user['created_at'],
            $user_details['name'],
            $user_details['surname'],
            $user_details['phone'],
            $user_details['image'],
            $user_details['role']
        );
    }

    public function setImage(string $email, string $newImageName)
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE user_details SET image = :newImage FROM users WHERE users.id_user_details = user_details.id and users.email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':newImage', $newImageName, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function userExists(string $email): bool
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users WHERE email = :email;
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == false)
        {
            return false;
        }
        return true;
    }

    public function changePersonalDetails(User $user)
    {
        $user_id = $user->getIdDatabase();
        $name = $user->getName();
        $surname = $user->getSurname();
        $phone = $user->getPhone();
        $email = $user->getEmail();

        $stmt = $this->database->connect()->prepare('
            UPDATE user_details SET name = :newName, surname = :newSurname, phone = :newPhone FROM users WHERE users.id_user_details = user_details.id and users.id = :userID;
        ');
        $stmt->bindParam(':newName', $name, PDO::PARAM_STR);
        $stmt->bindParam(':newSurname', $surname, PDO::PARAM_STR);
        $stmt->bindParam(':newPhone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':userID', $user_id, PDO::PARAM_STR);
        $stmt->execute();

        $stmt = $this->database->connect()->prepare('
            UPDATE users SET email = :newEmail WHERE id = :userID;
        ');
        $stmt->bindParam(':userID', $user_id, PDO::PARAM_STR);
        $stmt->bindParam(':newEmail', $email, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function updatePassword(User $user)
    {
        $password = $user->getPassword();
        $user_id = $user->getIdDatabase();

        $stmt = $this->database->connect()->prepare('
            UPDATE users SET password = :newPassword WHERE id = :userID;
        ');
        $stmt->bindParam(':newPassword', $password);
        $stmt->bindParam(':userID', $user_id);
        $stmt->execute();
    }

}