<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Command\UpdateSmartphoneCommand;
use App\Model\Smartphone;
use App\Model\Smartphone\Id;
use App\Model\Smartphones;

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
            Smartphone\Model::chooseFromList(
                $command->getModel()['company'],
                $command->getModel()['model']
            ),
            Smartphone\ReleaseDate::fromImmutableDateTime(new \DateTimeImmutable('now'))
        );

        $this->smartphones->update($updatedSmartphone);
    }
}