<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Command\RemoveSmartphoneCommand;
use App\Model\Smartphone;
use App\Model\Smartphones;

final class RemoveSmartphoneHandler
{
    private $smartphones;

    public function __construct(Smartphones $smartphones)
    {
        $this->smartphones = $smartphones;
    }

    public function handle(RemoveSmartphoneCommand $command): void
    {
        $smartphone = $this->smartphones->findById(Smartphone\Id::fromString($command->getId()));

        $this->smartphones->remove($smartphone);
    }
}