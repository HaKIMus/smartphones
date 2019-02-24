<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Exception\InvalidArgumentException;

abstract class ValueObject
{
    final protected function instanceOf(string $valueObject)
    {
        if (!class_exists($valueObject)) {
            throw new InvalidArgumentException(sprintf(
                'Given class %s doesn\'t exist',
                $valueObject
            ));
        }

        if (!static::class instanceof $valueObject) {
            throw new InvalidArgumentException(sprintf(
                'Instance of "%s" object required',
                self::class
            ));
        }
    }

    abstract public function sameValueAs(ValueObject $valueObject): bool;
}