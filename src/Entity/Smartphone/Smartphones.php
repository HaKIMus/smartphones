<?php

declare(strict_types=1);

namespace App\Entity\Smartphone;

use App\Entity\Smartphone\ValueObject\Id;

interface Smartphones
{
    public function add(Smartphone $smartphone): void;

    public function update(Smartphone $smartphone): void;

    public function remove(Smartphone $smartphone): void;

    public function findById(Id $id): ?Smartphone;

    /**
     * @return null|array|Smartphone[]
     */
    public function findAll(): ?array;
}