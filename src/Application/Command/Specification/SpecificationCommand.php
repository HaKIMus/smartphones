<?php

declare(strict_types=1);

namespace App\Application\Command\Specification;

final class SpecificationCommand
{
    private $id;

    private $company;

    private $model;

    private $details;

    public function __construct(
        IdCommand $id,
        CompanyCommand $company,
        ModelCommand $model,
        DetailsCommand $details
    ) {
        $this->id = $id;
        $this->company = $company;
        $this->model = $model;
        $this->details = $details;
    }

    public function getId(): IdCommand
    {
        return $this->id;
    }

    public function getCompany(): CompanyCommand
    {
        return $this->company;
    }

    public function getModel(): ModelCommand
    {
        return $this->model;
    }

    public function getDetails(): DetailsCommand
    {
        return $this->details;
    }
}