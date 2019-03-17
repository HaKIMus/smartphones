<?php

declare(strict_types=1);

namespace App\Entity\Specification\ValueObject;

use App\Entity\ValueObject;

final class Model extends ValueObject implements \JsonSerializable
{
    private $model;

    public static function fromString(string $model): self
    {
        return new self($model);
    }

    private function __construct(string $model)
    {
        $this->model = $model;
    }

    public function model(): string
    {
        return $this->model;
    }

    public function changeModel(string $model): self
    {
        return new self($model);
    }

    public function jsonSerialize(): array
    {
        return [
            'model' => $this->model,
        ];
    }

    public function __toString(): string
    {
        return $this->model;
    }

    public function sameValueAs(ValueObject $valueObject): bool
    {
        $this->isInstanceOf($valueObject);

        return $this->model === $valueObject->model;
    }
}