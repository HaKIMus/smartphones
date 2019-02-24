<?php

declare(strict_types=1);

namespace App\Entity;

interface AggregateRoot
{
    public function aggregateId(): string;
}