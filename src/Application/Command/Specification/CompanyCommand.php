<?php

declare(strict_types=1);

namespace App\Application\Command\Specification;

final class CompanyCommand
{
    private $company;

    public function __construct(string $company)
    {
        $this->company = $company;
    }
}