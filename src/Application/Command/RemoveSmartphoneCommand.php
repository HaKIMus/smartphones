<?php

declare(strict_types=1);

namespace App\Application\Command;

final class RemoveSmartphoneCommand
{
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}