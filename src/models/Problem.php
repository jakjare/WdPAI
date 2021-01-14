<?php


class Problem
{
    private $id;
    private $problem_status;
    private $ack_user;
    private $reporting_user;
    private $device;
    private $description;
    private $date;
    private $duration;

    public function __construct(int $id, $problem_status, $ack_user, $reporting_user, $device, string $description, string $date, string $duration)
    {
        $this->id = $id;
        $this->problem_status = $problem_status;
        $this->ack_user = $ack_user;
        $this->reporting_user = $reporting_user;
        $this->device = $device;
        $this->description = $description;
        $this->date = $date;
        $this->duration = $duration;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getDuration(): string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): void
    {
        $this->duration = $duration;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getProblemStatus()
    {
        return $this->problem_status;
    }

    public function setProblemStatus($problem_status): void
    {
        $this->problem_status = $problem_status;
    }

    public function getAckUser()
    {
        return $this->ack_user;
    }

    public function setAckUser($ack_user): void
    {
        $this->ack_user = $ack_user;
    }

    public function getReportingUser()
    {
        return $this->reporting_user;
    }

    public function setReportingUser($reporting_user): void
    {
        $this->reporting_user = $reporting_user;
    }

    public function getDevice()
    {
        return $this->device;
    }

    public function setDevice($device): void
    {
        $this->device = $device;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}