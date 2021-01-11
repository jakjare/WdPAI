<?php


class OperationStatus
{
    private $id;
    private $description;
    private $color;

    public function __construct(int $id, string $description, string $color)
    {
        $this->id = $id;
        $this->description = $description;
        $this->color = $color;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }
}