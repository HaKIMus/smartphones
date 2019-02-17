<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Command\CreateNewSmartphoneCommand;
use App\Entity\Smartphone;
use App\Entity\Smartphones;
use App\Entity\Specification;

final class CreateNewSmartphoneHandler
{
    private $smartphones;

    public function __construct(Smartphones $smartphones)
    {
        $this->smartphones = $smartphones;
    }

    public function handle(CreateNewSmartphoneCommand $command): void
    {
        $specificationCommand = $command->getSpecification();

        $specification = new Specification(
            Specification\Id::generate(),
            Specification\Company::fromList($specificationCommand->getCompany()),
            Specification\Model::fromString($specificationCommand->getModel()),
            Specification\Details::withDetails(
                $specificationCommand->getOs(),
                $specificationCommand->getScreenSize(),
                $specificationCommand->getScreenResolution(),
                new \DateTimeImmutable($specificationCommand->getReleasedDate())
            )
        );

        $smartphone = Smartphone::withSpecification(
            Smartphone\Id::fromString($command->getId()),
            $specification
        );

        $this->smartphones->add($smartphone);
    }
}