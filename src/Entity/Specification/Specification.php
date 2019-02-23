<?php

declare(strict_types=1);

namespace App\Entity\Specification;

use App\Entity\Specification\ValueObject\Company;
use App\Entity\Specification\ValueObject\Details;
use App\Entity\Specification\ValueObject\Id;
use App\Entity\Specification\ValueObject\Model;

/* final */class Specification
{
    private $id;

    private $company;

    private $model;

    private $details;

    public function __construct(Id $id, Company $company, Model $model, Details $details)
    {
        $this->id = $id;
        $this->company = $company;
        $this->model = $model;
        $this->details = $details;
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function changeCompany(Company $company): void
    {
        $this->company = $company;
    }

    public function changeModel(Model $model): void
    {
        $this->model = $model;
    }

    public function changeDetails(Details $details): void
    {
        $this->details = $details;
    }

    public function company(): Company
    {
        return $this->company;
    }

    public function model(): Model
    {
        return $this->model;
    }

    public function details(): Details
    {
        return $this->details;
    }
}