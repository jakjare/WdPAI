<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Problem.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../models/Device.php';
require_once __DIR__.'/../models/ProblemStatus.php';

class ProblemRepository extends Repository
{
    const TIME_FORMAT = 'DD;HH24;MI;SS';

    public function getAdminProblems(User $user): array
    {
        $id_user = $user->getIdDatabase();
        $format = self::TIME_FORMAT;

        $stmt = $this->database->connect()->prepare('
            SELECT to_char(age(current_timestamp, p.date), :format) as duration, p.*, ps.name FROM problems p LEFT JOIN problem_status ps on p.id_problem_status = ps.id WHERE (id_ack_user = :id_user OR id_ack_user IS NULL) AND id_problem_status <> 2 ORDER BY p.date DESC;

        ');
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':format', $format);
        $stmt->execute();

        $problems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->prepareResult($problems);
    }

    public function getProblemById(int $id): Problem
    {
        $format = self::TIME_FORMAT;

        $stmt = $this->database->connect()->prepare('
            SELECT to_char(age(current_timestamp, p.date), :format) as duration, p.*, ps.name FROM problems p LEFT JOIN problem_status ps on p.id_problem_status = ps.id WHERE p.id = :id;
        ');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':format', $format);
        $stmt->execute();

        $problem[0] = $stmt->fetch(PDO::FETCH_ASSOC);

        return $this->prepareResult($problem)[0];
    }

    public function getProblemsByDeviceId(int $id)
    {
        $format = self::TIME_FORMAT;

        $stmt = $this->database->connect()->prepare('
            SELECT to_char(age(current_timestamp, p.date), :format) as duration, p.*, ps.name FROM problems p LEFT JOIN problem_status ps on p.id_problem_status = ps.id WHERE p.id_device = :id;
        ');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':format', $format);
        $stmt->execute();

        $problems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->prepareResult($problems);
    }

    public function getProblemStatuses(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM problem_status;
        ');
        $stmt->execute();
        $statuses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($statuses as $status)
            $result[] = new ProblemStatus($status['id'], $status['name']);

        return $result;
    }

    public function setProblemStatus(int $id_problem, int $id_status): void
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE problems SET id_problem_status = :id_status WHERE id = :id_problem;
        ');
        $stmt->bindParam(':id_status', $id_status);
        $stmt->bindParam(':id_problem', $id_problem);
        $stmt->execute();
    }

    public function setProblemAckUser(int $id_problem, int $id_user): void
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE problems SET id_ack_user = :id_user WHERE id = :id_problem;
        ');
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':id_problem', $id_problem);
        $stmt->execute();
    }

    public function addProblem(Problem $problem): void
    {
        $id_reporting_user = $problem->getReportingUser();
        $description = $problem->getDescription();
        $id_device = $problem->getDevice();

        $stmt = $this->database->connect()->prepare('
            INSERT INTO problems VALUES (default, default, null, :id_reporting_user, :description, :id_device, default);
        ');
        $stmt->bindParam(':id_reporting_user', $id_reporting_user);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id_device', $id_device);
        $stmt->execute();
    }

    private function prepareResult(array $problems): array
    {
        $result = [];

        foreach ($problems as $problem)
        {
            $result[] = new Problem(
                $problem['id'],
                $problem['name'],
                $problem['id_ack_user'],
                $problem['id_reporting_user'],
                $problem['id_device'],
                $problem['description'],
                substr($problem['date'], 0, 19),
                $problem['duration']
            );
        }

        return $result;
    }
}