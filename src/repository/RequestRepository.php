<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Request.php';
require_once __DIR__.'/../models/User.php';

class RequestRepository extends Repository
{
    public function getRequestsForUser(User $user, bool $archived): array
    {
        $id_receiver = $user->getIdDatabase();
        $stmt = $this->database->connect()->prepare('
            SELECT r.* FROM requests r LEFT JOIN request_receiver rr on r.id = rr.id_request WHERE rr.id_user = :id_receiver AND r.archived = :archived ORDER BY r.time DESC;
        ');
        $stmt->bindParam(':id_receiver', $id_receiver);
        $stmt->bindParam(':archived', $archived, PDO::PARAM_BOOL);
        $stmt->execute();
        $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->prepareResult($requests);
    }

    public function getRequestById(int $id): Request
    {
        $this->setRead($id);
        $stmt = $this->database->connect()->prepare('
            SELECT r.* FROM requests r  WHERE r.id = :id;
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $request[0] = $stmt->fetch(PDO::FETCH_ASSOC);

        return $this->prepareResult($request)[0];
    }

    public function addRequest(Request $request, array $receivers)
    {
        $id_sender = $request->getSender();
        $id_device = $request->getDevice();
        $topic = $request->getTopic();
        $content = $request->getContent();
        $important = $request->getImportant();

        $id_user = '{';
        foreach ($receivers as $id)
        {
            $id_user = $id_user.$id;
            $id_user = next($receivers) ? $id_user.',' : $id_user.'}';
        }

        $stmt = $this->database->connect()->prepare('
            CALL add_request(:id_sender, :id_device, :topic, :content, :important, :id_user);
        ');
        $stmt->bindParam(':id_sender', $id_sender, PDO::PARAM_INT);
        if ($id_device == null)
        {
            $stmt->bindParam(':id_device', $id_device, PDO::PARAM_NULL);
        } else {
            $stmt->bindParam(':id_device', $id_device, PDO::PARAM_INT);
        }
        $stmt->bindParam(':topic', $topic);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':important', $important, PDO::PARAM_BOOL);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->execute();
    }

    public function changeArchivedStatus(int $id)
    {
        $stmt = $this->database->connect()->prepare('
            CALL change_archived_request(:id);
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    private function prepareResult(array $requests): array
    {
        $result = [];

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

    private function setRead(int $id)
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE requests SET read = true WHERE id = :id;
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}