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

        $smartphoneId = $command->getSmartphone()->getId()->getId();

        $company = $specificationCommand->getCompany()->getCompany();
        $model = $specificationCommand->getModel()->getModel();
        $details = $specificationCommand->getDetails();

        $specification = new Specification(
            Specification\Id::generate(),
            Specification\Company::fromList($company),
            Specification\Model::fromString($model),
            Specification\Details::withDetails(
                $details->getOs(),
                $details->getScreenSize(),
                $details->getScreenResolution(),
                new \DateTimeImmutable($details->getReleasedDate())
            )
        );

        $smartphone = Smartphone::withSpecification(
            Smartphone\Id::fromString($smartphoneId),
            $specification
        );

        $this->smartphones->add($smartphone);
    }
}