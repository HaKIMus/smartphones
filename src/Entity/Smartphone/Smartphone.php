<?php

declare(strict_types=1);

namespace App\Entity\Smartphone;

use App\Entity\AggregateRoot;
use App\Entity\Smartphone\ValueObject\Id;
use App\Entity\Specification\Specification;
use Ramsey\Uuid\Uuid;

final class Smartphone implements AggregateRoot, \JsonSerializable
{
    private $id;

    private $specification;

    private $aggregateId;

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

        $this->aggregateId = Uuid::uuid4();
    }

    public function aggregateId(): string
    {
        return (string) $this->aggregateId;
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