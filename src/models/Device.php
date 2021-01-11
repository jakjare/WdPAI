<?php

class Device
{
    private $id;
    private $name;
    private $comment;
    private $ip_address;
    private $location;
    private $operation_status;
    private $color_string;
    private $status;

    public function __construct(int $id, string $name, string $comment, string $ip_address, string $location, string $operation_status, string $color_string, bool $status)
    {
        $this->id = $id;
        $this->name = $name;
        $this->comment = $comment;
        $this->ip_address = $ip_address;
        $this->location = $location;
        $this->operation_status = $operation_status;
        $this->color_string = $color_string;
        $this->status = $status;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getColorString(): string
    {
        return $this->color_string;
    }

    public function setColorString(string $color_string): void
    {
        $this->color_string = $color_string;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function getIpAddress(): string
    {
        return $this->ip_address;
    }

    public function setIpAddress(string $ip_address): void
    {
        $this->ip_address = $ip_address;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    public function getOperationStatus(): string
    {
        return $this->operation_status;
    }

    public function setIdOperationStatus(string $operation_status): void
    {
        $this->operation_status = $operation_status;
    }

    public function isStatus(): bool
    {
        return $this->status;
    }

    public function changeStatus(): void
    {
        $this->status = !$this->status;
    }
}