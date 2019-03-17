<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Exception\InvalidArgumentException;

abstract class ValueObject
{
    final protected function isInstanceOf(ValueObject $valueObject): void
    {
        if (! $valueObject instanceof static) {
            throw new InvalidArgumentException(sprintf(
                'Instance of "%s" object required',
                self::class
            ));
        }
    }

    abstract public function __toString(): string;

    abstract public function sameValueAs(ValueObject $valueObject): bool;
}