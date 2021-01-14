<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class PermissionRepository extends Repository
{
    public function getPages(): array
    {
        session_start();
        $session_id = session_id();
        $stmt = $this->database->connect()->prepare('
            SELECT p.* FROM active_sessions sessions
            LEFT JOIN users u on sessions.id_user = u.id
            LEFT JOIN user_details ud on u.id_user_details = ud.id
            LEFT JOIN roles r on ud.role = r.id
            LEFT JOIN role_page rp on r.id = rp.id_role
            LEFT JOIN pages p on rp.id_page = p.id
            WHERE sessions.id = :session_id;
        ');
        $stmt->bindParam(':session_id', $session_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteSession(): void
    {
        session_start();
        $session_id = session_id();
        $stmt = $this->database->connect()->prepare('
            DELETE FROM active_sessions WHERE id = :session_id;
        ');
        $stmt->bindParam(':session_id', $session_id);
        $stmt->execute();
    }
}