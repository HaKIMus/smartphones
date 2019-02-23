<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Application\Query\Model\SmartphoneModel;
use App\Entity\Smartphone\ValueObject\Id;

interface SmartphoneQuery
{
    public function findById(Id $id): ?SmartphoneModel;

    /**
     * @return null|array|SmartphoneModel[]
     */
    public function findAll(): ?array;
}