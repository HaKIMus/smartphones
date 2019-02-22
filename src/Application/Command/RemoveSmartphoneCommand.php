<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Application\Command\Smartphone\IdCommand;

final class RemoveSmartphoneCommand
{
    private $smartphoneId;

    public function __construct(IdCommand $smartphoneId)
    {
        $this->smartphoneId = $smartphoneId;
    }

    public function getSmartphoneId(): IdCommand
    {
        return $this->smartphoneId;
    }
}