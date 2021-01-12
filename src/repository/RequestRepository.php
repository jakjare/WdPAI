<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Request.php';
require_once __DIR__.'/../models/User.php';

class RequestRepository extends Repository
{
    public function getRequestsForUser(User $user, bool $archived = false): array
    {
        $result = [];

        $id_receiver = $user->getIdDatabase();
        $stmt = $this->database->connect()->prepare('
            SELECT r.* FROM requests r LEFT JOIN request_receiver rr on r.id = rr.id_request WHERE rr.id_user = :id_receiver;
        ');
        $stmt->bindParam(':id_receiver', $id_receiver);
        $stmt->execute();
        $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($requests as $request)
        {
            $result[] = new Request(
                $request['id'],
                $request['id_sender'],
                $request['id_device'],
                $request['topic'],
                $request['content'],
                substr($request['time'], 0, 19),
                $request['archived'],
                $request['important'],
                $request['read']
            );
        }

        return $result;
    }
}