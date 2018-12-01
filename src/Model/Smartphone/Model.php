<?php

declare(strict_types=1);

namespace App\Model\Smartphone;

use App\Model\Exception\Smartphone\UnknownCompanyException;
use App\Model\Exception\Smartphone\UnknownModelException;

final class Model implements \JsonSerializable
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

    public function toArray(): array
    {
        return [
            $this->company,
            $this->model,
        ];
    }

    public function __toString(): string
    {
        return json_encode([
                'company' => $this->company,
                'model' => $this->model,
            ]
        );
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize(): array
    {
        return [
            'company' => $this->company,
            'model' => $this->model,
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