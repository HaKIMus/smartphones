<?php

declare(strict_types=1);

namespace App\Application\Dto;

final class SpecificationAttachedToSmartphone
{
    private $company;

    private $model;

    private $os;

    private $screenSize;

    private $screenResolution;

    private $releasedDate;

    public function __construct(
        string $company,
        string $model,
        string $os,
        array $screenSize,
        array $screenResolution,
        string $releasedDate
    ) {
        $this->company = $company;
        $this->model = $model;
        $this->os = $os;
        $this->screenSize = $screenSize;
        $this->screenResolution = $screenResolution;
        $this->releasedDate = $releasedDate;
    }

    public function getOs(): string
    {
        return $this->os;
    }

    public function getCompany(): string
    {
        return $this->company;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getScreenSize(): array
    {
        return $this->screenSize;
    }

    public function getScreenResolution(): array
    {
        return $this->screenResolution;
    }

    public function getReleasedDate(): string
    {
        return $this->releasedDate;
    }
}