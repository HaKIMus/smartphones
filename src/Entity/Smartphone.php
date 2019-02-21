<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Smartphone\Id;

final class Smartphone implements \JsonSerializable
{
    private $id;

    private $specification;

    public static function withSpecification(
        Id $id,
        Specification $specification
    ): self {
        return new self(
            $id,
            $specification
        );
    }

    private function __construct(
        Id $id,
        Specification $specification
    ) {
        $this->id = $id;
        $this->specification = $specification;
    }

    public function specification(): Specification
    {
        return $this->specification;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'specification' => $this->specification,
        ];
    }
}