<?php

declare(strict_types=1);

namespace App\Model\Smartphone;

use App\Model\Exception\Smartphone\UnknownCompanyException;
use App\Model\Exception\Smartphone\UnknownModelException;

final class Model
{
    const COMPANIES = [
        'ALONESUNG',
        'MYPHONE',
        'SHAOLIN',
    ];

    const MODELS = [
        'ALONESUNG' => [
            'MILKY WAY 1',
            'MILKY WAY 2',
        ]
    ];

    private $company;

    private $model;

    public static function chooseFromList(string $company, string $model): self
    {
        if (!self::givenCompanyExist($company)) {
            throw new UnknownCompanyException(sprintf(
                'There is no company like %s',
                $company
            ));
        }

        if (!self::givenModelExist($model, $company)) {
            throw new UnknownModelException(sprintf(
                'There is no model like %s',
                $model
            ));
        }

        return new self($company, $model);
    }

    private function __construct(string $company, string $model)
    {
        $this->company = $company;
        $this->model = $model;
    }

    public function getCompany(): string
    {
        return $this->company;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    private static function givenCompanyExist(string $company): bool
    {
        if(in_array($company, self::COMPANIES)) {
            return true;
        }

        return false;
    }

    private static function givenModelExist(string $model, string $company): bool
    {
        if (in_array($model, self::MODELS[$company])) {
            return true;
        }

        return false;
    }
}