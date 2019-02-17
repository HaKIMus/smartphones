<?php

declare(strict_types=1);

namespace App\Application\Query\Model;

final class SmartphoneModel implements \JsonSerializable
{
    private $id;

    private $company;

    private $model;

    private $details;

    private $specification;

    public function __construct(
        string $id,
        string $company,
        string $model,
        array $details
    ) {
        $this->id = $id;
        $this->company = $company;
        $this->model = $model;
        $this->details = $details;

        $this->specification = [
            'company' => $this->company,
            'model' => $this->model,
            'details' => $this->details,
        ];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCompany(): string
    {
        return $this->company;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getSpecification(): array
    {
        return $this->specification;
    }

    public function getDetails(): array
    {
        return $this->details;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'specification' => $this->specification,
        ];
    }
}