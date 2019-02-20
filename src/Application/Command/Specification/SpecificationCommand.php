<?php

declare(strict_types=1);

namespace App\Application\Command\Specification;

final class SpecificationCommand
{
    private $id;

    private $command;

    private $model;

    private $details;

    public function __construct(
        IdCommand $id,
        CompanyCommand $command,
        ModelCommand $model,
        DetailsCommand $details
    ) {
        $this->id = $id;
        $this->command = $command;
        $this->model = $model;
        $this->details = $details;
    }

    public function getId(): IdCommand
    {
        return $this->id;
    }

    public function getCommand(): CompanyCommand
    {
        return $this->command;
    }

    public function getModel(): ModelCommand
    {
        return $this->model;
    }

    public function getDetails(): DetailsCommand
    {
        return $this->details;
    }
}