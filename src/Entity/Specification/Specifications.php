<?php

declare(strict_types=1);

namespace App\Entity\Specification;

use App\Entity\Specification\ValueObject\Id;

interface Specifications
{
    public function add(Specification $specification): void;

    public function update(Specification $specification): void;

    public function remove(Specification $specification): void;

    public function findById(Id $id): ?Specification;

    /**
     * @return null|array|Specification[]
     */
    public function findAll(): ?array;
}