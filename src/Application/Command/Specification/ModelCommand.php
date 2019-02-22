<?php

declare(strict_types=1);

namespace App\Application\Command\Specification;

final class ModelCommand
{
    private $model;

    public function __construct(string $model)
    {
        $this->model = $model;
    }

    public function getModel(): string
    {
        return $this->model;
    }
}