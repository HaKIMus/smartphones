<?php

declare(strict_types=1);

namespace App\Entity\Specification;

final class Model implements \JsonSerializable
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

    public function jsonSerialize(): array
    {
        return [
            'model' => $this->model,
        ];
    }
}