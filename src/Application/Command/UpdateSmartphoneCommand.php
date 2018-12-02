<?php

declare(strict_types=1);

namespace App\Application\Command;

final class UpdateSmartphoneCommand
{
    private $id;

    private $model;

    private $releaseDate;

    public function __construct(
        string $id,
        array $model,
        string $releaseDate
    ) {
        $this->id = $id;
        $this->model = $model;
        $this->releaseDate = $releaseDate;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getModel(): array
    {
        return $this->model;
    }

    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }
}