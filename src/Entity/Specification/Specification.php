<?php

declare(strict_types=1);

namespace App\Entity\Specification;

use App\Entity\AggregateRoot;
use App\Entity\Specification\ValueObject\Company;
use App\Entity\Specification\ValueObject\Details;
use App\Entity\Specification\ValueObject\Id;
use App\Entity\Specification\ValueObject\Model;
use Ramsey\Uuid\Uuid;

/* final */class Specification implements AggregateRoot
{
    private $id;

    private $company;

    private $model;

    private $details;

    private $aggregateId;

    public function __construct(Id $id, Company $company, Model $model, Details $details)
    {
        $this->id = $id;
        $this->company = $company;
        $this->model = $model;
        $this->details = $details;

        $this->aggregateId = Uuid::uuid4();
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function aggregateId(): string
    {
        return (string) $this->aggregateId;
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

    public function compare(Specification $specification): array
    {
        $specificationDetails = $specification->details->details();

        $differences = [];

        foreach ($specificationDetails as $key => $specificationDetail) {
            $specificationToCompareDetails = $this->details->details()[$key];

            if ($specificationDetail !== $specificationToCompareDetails) {
                $differences[] = [
                    1 => $specificationDetail,
                    'message' => 'Is different from',
                    2 => $specificationToCompareDetails
                ];
            }
        }

        array_push($specificationDetails,['differences' => $differences]);

        dump($specificationDetails);

        return $specificationDetails;
    }
}