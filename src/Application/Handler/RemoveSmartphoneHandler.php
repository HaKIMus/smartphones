<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Command\RemoveSmartphoneCommand;
use App\Entity\Smartphone\Smartphones;
use App\Entity\Smartphone\ValueObject\Id;

final class RemoveSmartphoneHandler
{
    private $smartphones;

    public function __construct(Smartphones $smartphones)
    {
        $this->smartphones = $smartphones;
    }

    public function handle(RemoveSmartphoneCommand $command): void
    {
        $smartphone = $this->smartphones->findById(Id::fromString($command->getSmartphoneId()->getId()));

        $this->smartphones->remove($smartphone);
    }
}