<?php

declare(strict_types=1);

namespace App\Application\Query\Model;

final class SmartphoneModel implements \JsonSerializable
{
    private $id;

    private $specification;

    private $releaseDate;

    public function __construct(
        string $id,
        array $model,
        string $releaseDate
    ) {
        $this->id = $id;
        $this->specification = $model;
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

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'specification' => $this->specification,
            'releaseDate' => $this->releaseDate
        ];
    }
}