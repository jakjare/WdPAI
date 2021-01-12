<?php

require_once 'User.php';

class Request
{
    private $id;
    private $sender;
    private $device;
    private $topic;
    private $content;
    private $time;
    private $archived;
    private $important;
    private $read;

    public function __construct(int $id, $sender, $device, string $topic, string $content, string $time = null, bool $archived = false, $important = false, bool $read = false)
    {
        $this->id = $id;
        $this->sender = $sender;
        $this->device = $device;
        $this->topic = $topic;
        $this->content = $content;
        $this->time = $time;
        $this->archived = $archived;
        $this->important = $important;
        $this->read = $read;
    }

    public function isRead(): bool
    {
        return $this->read;
    }

    public function setRead(bool $read): void
    {
        $this->read = $read;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function setSender($sender): void
    {
        $this->sender = $sender;
    }

    public function getDevice()
    {
        return $this->device;
    }

    public function setDevice($device): void
    {
        $this->device = $device;
    }

    public function getTopic(): string
    {
        return $this->topic;
    }

    public function setTopic(string $topic): void
    {
        $this->topic = $topic;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getTime(): string
    {
        return $this->time;
    }

    public function setTime(string $time): void
    {
        $this->time = $time;
    }

    public function isArchived(): bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): void
    {
        $this->archived = $archived;
    }

    public function getImportant(): bool
    {
        return $this->important;
    }

    public function setImportant(bool $important): void
    {
        $this->important = $important;
    }
}