<?php

declare(strict_types=1);

namespace App\Application\Command\Smartphone;

use App\Application\Command\Specification\SpecificationCommand;

final class SmartphoneCommand
{
    private $id;

    private $specification;

    public function __construct(
        IdCommand $id,
        SpecificationCommand $specification
    ) {
        $this->id = $id;
        $this->specification = $specification;
    }

    public function getId(): IdCommand
    {
        return $this->id;
    }

    public function getSpecification(): SpecificationCommand
    {
        return $this->specification;
    }
}