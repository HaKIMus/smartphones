<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Application\Dto\SpecificationAttachedToSmartphone;

final class UpdateSmartphoneCommand
{
    private $id;

    private $specification;

    public function __construct(
        string $id,
        SpecificationAttachedToSmartphone $specification
    ) {
        $this->id = $id;
        $this->specification = $specification;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSpecification(): SpecificationAttachedToSmartphone
    {
        return $this->specification;
    }
}