<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Command\CreateNewSmartphoneCommand;
use App\Entity\Smartphone;
use App\Entity\Smartphones;

final class CreateNewSmartphoneHandler
{
    private $smartphones;

    public function __construct(Smartphones $smartphones)
    {
        $this->smartphones = $smartphones;
    }

    public function handle(CreateNewSmartphoneCommand $command): void
    {
        $smartphone = Smartphone::withSpecification(
            Smartphone\Id::fromString($command->getId()),
            Smartphone\Model::chooseFromList(
                $command->getModel()['company'],
                $command->getModel()['model']
            ),
            Smartphone\ReleaseDate::fromImmutableDateTime(
                new \DateTimeImmutable($command->getReleaseDate()))
        );

        $this->smartphones->add($smartphone);
    }
}