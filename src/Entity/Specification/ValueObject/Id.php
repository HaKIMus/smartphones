<?php

declare(strict_types=1);

namespace App\Entity\Specification\ValueObject;

use App\Entity\ValueObject;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class Id extends ValueObject
{
    private $id;

    public static function fromString(string $uuid): self
    {
        return new self(Uuid::fromString($uuid));
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid4());
    }

    private function __construct(UuidInterface $uuid)
    {
        $this->id = $uuid;
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string) $this->id;
    }

    public function sameValueAs(ValueObject $valueObject): bool
    {
        $this->instanceOf(get_class($valueObject));

        return $this->id === $valueObject->id;
    }
}