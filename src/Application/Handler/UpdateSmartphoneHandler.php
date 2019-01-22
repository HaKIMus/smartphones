<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Command\UpdateSmartphoneCommand;
use App\Entity\Smartphone;
use App\Entity\Smartphone\Id;
use App\Entity\Smartphones;

final class UpdateSmartphoneHandler
{
    private $smartphones;

    public function __construct(Smartphones $smartphones)
    {
        $this->smartphones = $smartphones;
    }

    public function handle(UpdateSmartphoneCommand $command): void
    {
        $smartphone = $this->smartphones->findById(Id::fromString($command->getId()));

        $updatedSmartphone = $smartphone->updateSpecification(
            Smartphone\Specification::chooseOneFromList(
                $command->getSpecification()['company'],
                $command->getSpecification()['model']
            ),
            Smartphone\ReleaseDate::fromImmutableDateTime(new \DateTimeImmutable($command->getReleaseDate()))
        );

        $this->smartphones->update($updatedSmartphone);
    }
}