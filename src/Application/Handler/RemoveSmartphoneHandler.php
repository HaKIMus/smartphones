<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Command\RemoveSmartphoneCommand;
use App\Entity\Smartphone;
use App\Entity\Smartphones;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class RemoveSmartphoneHandler
{
    private $smartphones;

    public function __construct(Smartphones $smartphones)
    {
        $this->smartphones = $smartphones;
    }

    public function handle(RemoveSmartphoneCommand $command): void
    {
        $smartphone = $this->smartphones->findById(Smartphone\Id::fromString($command->getSmartphoneId()->getId()));

        $this->smartphones->remove($smartphone);
    }
}