<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $email): ?User
    {
        $stmt =$this->database->connect()->prepare('
            SELECT * FROM user_full WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
            //TODO zamiast zwracać nulla należy zwracać exception
        }

        return new User(
            $user['id'],
            $user['email'],
            $user['password'],
            $user['enabled'],
            $user['created_at'],
            $user['name'],
            $user['surname'],
            $user['phone'],
            $user['image'],
            $user['description'],
            $user['date']
        );
    }

    public function getUserById(int $id): ?User
    {
        $stmt =$this->database->connect()->prepare('
            SELECT * FROM user_full WHERE id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
            //TODO zamiast zwracać nulla należy zwracać exception
        }

        return new User(
            $user['id'],
            $user['email'],
            $user['password'],
            $user['enabled'],
            $user['created_at'],
            $user['name'],
            $user['surname'],
            $user['phone'],
            $user['image'],
            $user['description'],
            $user['date']
        );
    }

    public function userLogin(int $id, bool $succesful): void
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO login_history VALUES (DEFAULT, :userID, DEFAULT, :userIP, :succesful);
        ');
        $stmt->bindParam(':userID', $id);
        $user_IP = $_SERVER['REMOTE_ADDR'];
        $stmt->bindParam(':userIP', $user_IP);
        $stmt->bindParam(':succesful', $succesful, PDO::PARAM_BOOL);
        $stmt->execute();
    }

    public function setSession(int $id): void
    {
        session_start();
        $session_id = session_id();

        $stmt = $this->database->connect()->prepare('
            DELETE FROM active_sessions WHERE id = :session_id;
        ');
        $stmt->bindParam(':session_id', $session_id);
        $stmt->execute();

        $stmt = $this->database->connect()->prepare('
            INSERT INTO active_sessions VALUES (:session_id, :userID, DEFAULT, DEFAULT);
        ');
        $stmt->bindParam(':session_id', $session_id);
        $stmt->bindParam(':userID', $id);
        $stmt->execute();
    }

    public function setImage(string $email, string $newImageName): void
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

    public function changePersonalDetails(User $user): void
    {
        $user_id = $user->getIdDatabase();
        $name = $user->getName();
        $surname = $user->getSurname();
        $phone = $user->getPhone();
        $email = $user->getEmail();
        $status = $user->isEnabled();
        $password = password_hash($user->getPassword(), PASSWORD_DEFAULT);

        $stmt = $this->database->connect()->prepare('
            UPDATE user_details SET name = :newName, surname = :newSurname, phone = :newPhone FROM users WHERE users.id_user_details = user_details.id and users.id = :userID;
        ');
        $stmt->bindParam(':newName', $name, PDO::PARAM_STR);
        $stmt->bindParam(':newSurname', $surname, PDO::PARAM_STR);
        $stmt->bindParam(':newPhone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':userID', $user_id, PDO::PARAM_STR);
        $stmt->execute();

        $stmt = $this->database->connect()->prepare('
            UPDATE users SET email = :newEmail, password = :password, enabled = :newStatus  WHERE id = :userID;
        ');
        $stmt->bindParam(':userID', $user_id, PDO::PARAM_STR);
        $stmt->bindParam(':newEmail', $email, PDO::PARAM_STR);
        $stmt->bindParam(':newStatus', $status, PDO::PARAM_BOOL);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function updatePassword(User $user): void
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

    public function getUsers(): array
    {
        $result = [];
        $stmt =$this->database->connect()->prepare('
            SELECT * FROM user_full;
        ');
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $user)
        {
            $result[] = new User(
                $user['id'],
                $user['email'],
                $user['password'],
                $user['enabled'],
                $user['created_at'],
                $user['name'],
                $user['surname'],
                $user['phone'],
                $user['image'],
                $user['description'],
                $user['date']
            );
        }

        return $result;
    }

    public function newUser(User $user): void
    {
        $name = $user->getName();
        $surname = $user->getSurname();
        $phone = $user->getPhone();
        $role = $user->getRole();
        $email = $user->getEmail();
        $password = password_hash($user->getPassword(), PASSWORD_DEFAULT);

        $stmt = $this->database->connect()->prepare('
            CALL add_user(:name, :surname, :phone, :role, :email, :password);
        ');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':role', $role, PDO::PARAM_INT);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
    }

    public function deleteUser(User $user): void
    {
        $stmt = $this->database->connect()->prepare('
            CALL delete_user(:id);
        ');
        $id = $user->getIdDatabase();
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getUsersByRole(string $role): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM user_full WHERE description = :role;
        ');
        $stmt->bindParam(':role', $role);
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $user)
        {
            $result[] = new User(
                $user['id'],
                $user['email'],
                $user['password'],
                $user['enabled'],
                $user['created_at'],
                $user['name'],
                $user['surname'],
                $user['phone'],
                $user['image'],
                $user['description'],
                $user['date']
            );
        }

        return $result;
    }

    public function getOnlineStats(): int
    {
        $stmt = $this->database->connect()->prepare("
            SELECT COUNT(id) AS online FROM active_sessions WHERE last_update + INTERVAL '10 min' > current_timestamp GROUP BY id_user;
        ");
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)['online'];
    }

}