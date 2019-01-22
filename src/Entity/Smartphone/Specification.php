<?php

declare(strict_types=1);

namespace App\Entity\Smartphone;

use App\Entity\Exception\Smartphone\UnknownCompanyException;
use App\Entity\Exception\Smartphone\UnknownModelException;

final class Specification implements \JsonSerializable
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
        ],
        'MYPHONE' => [
            '1',
            '2',
        ],
    ];

    const DETAILS = [
        'ALONESUNG' => [
            'MILKY WAY 1' => [
                'DETAILS' => [
                    'OS' => 'Druid',
                    'SCREEN SIZE' => ['size' => '14.82', 'unit' => 'cm'],
                    'SCREEN RESOLUTION' => ['size' => '3225x5436', 'unit' => 'pixel'],
                ],
            ],
            'MILKY WAY 2' => [
                'DETAILS' => [
                    'OS' => 'Druid',
                    'SCREEN SIZE' => ['size' => '14.82', 'unit' => 'cm'],
                    'SCREEN RESOLUTION' => ['size' => '3225x5436', 'unit' => 'pixel'],
                ],
            ],
        ],
        'MYPHONE' => [
            '1' => [
                'DETAILS' => [
                    'OS' => 'SoS',
                    'SCREEN SIZE' => ['size' => '14.73', 'unit' => 'cm'],
                    'SCREEN RESOLUTION' => ['size' => '1225x2436', 'unit' => 'pixel'],
                ],
            ],
            '2' => [
                'DETAILS' => [
                    'OS' => 'SoS',
                    'SCREEN SIZE' => ['size' => '16.73', 'unit' => 'cm'],
                    'SCREEN RESOLUTION' => ['size' => '2225x4436', 'unit' => 'pixel'],
                ],
            ],
        ],
    ];

    private $company;

    private $model;

    private $details;

    public static function chooseOneFromList(string $company, string $model): self
    {
        return new self($company, $model);
    }

    private function __construct(string $company, string $model)
    {
        $company = mb_strtoupper($company);
        $model = mb_strtoupper($model);

        if (!self::givenCompanyExist($company)) {
            throw new UnknownCompanyException(sprintf(
                'There is no company like %s',
                $company
            ));
        }

        if (!self::givenModelExist($model, $company)) {
            throw new UnknownModelException(sprintf(
                'The company %s has no model like %s in our database',
                $company,
                $model
            ));
        }

        $this->company = $company;
        $this->model = $model;
        $this->details = self::DETAILS[$company][$model];
    }

    public function getCompany(): string
    {
        return $this->company;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getDetails(): array
    {
        return $this->details;
    }

    public function toArray(): array
    {
        return [
            $this->company,
            $this->model,
            $this->details,
        ];
    }

    public function __toString(): string
    {
        return json_encode([
                'company' => $this->company,
                'model' => $this->model,
                'details' => $this->details,
            ]
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'company' => $this->company,
            'model' => $this->model,
            'details' => $this->details,
        ];
    }

    private static function givenCompanyExist(string $company): bool
    {
        if (in_array($company, self::COMPANIES)) {
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