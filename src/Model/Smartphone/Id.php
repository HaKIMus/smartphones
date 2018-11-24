<?php

declare(strict_types=1);

namespace App\Model\Smartphone;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class Id
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

    public function __construct(UuidInterface $uuid)
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
}