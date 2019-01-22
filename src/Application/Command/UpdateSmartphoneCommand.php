<?php

declare(strict_types=1);

namespace App\Application\Command;

final class UpdateSmartphoneCommand
{
    private $id;

    private $specification;

    private $releaseDate;

    public function __construct(
        string $id,
        array $specification,
        string $releaseDate
    ) {
        $this->id = $id;
        $this->specification = $specification;
        $this->releaseDate = $releaseDate;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSpecification(): array
    {
        return $this->specification;
    }

    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }
}