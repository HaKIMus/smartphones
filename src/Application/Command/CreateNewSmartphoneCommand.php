<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Application\Command\Smartphone\SmartphoneCommand;
use App\Application\Command\Specification\SpecificationCommand;

final class CreateNewSmartphoneCommand
{
    private $smartphone;

    private $specification;

    public function __construct(
        SmartphoneCommand $smartphone,
        SpecificationCommand $specification
    ) {
        $this->smartphone = $smartphone;
        $this->specification = $specification;
    }

    public function getSmartphone(): SmartphoneCommand
    {
        return $this->smartphone;
    }

    public function getSpecification(): SpecificationCommand
    {
        return $this->specification;
    }
}