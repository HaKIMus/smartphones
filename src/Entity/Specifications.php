<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Specification\Id;

interface Specifications
{
    public function add(Specification $smartphone): void;

    public function update(Specification $smartphone): void;

    public function remove(Specification $smartphone): void;

    public function findById(Id $id): ?Specification;

    /**
     * @return null|array|Specification[]
     */
    public function findAll(): ?array;
}