<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Command\CreateNewSmartphoneCommand;
use App\Entity\Smartphone\Smartphone;
use App\Entity\Smartphone\Smartphones;
use App\Entity\Specification\Specification;
use App\Entity\Specification\ValueObject\Company;
use App\Entity\Specification\ValueObject\Details;
use App\Entity\Specification\ValueObject\Id as SpecificationId;
use App\Entity\Smartphone\ValueObject\Id as SmartphoneId;
use App\Entity\Specification\ValueObject\Model;

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
            SpecificationId::generate(),
            Company::fromList($company),
            Model::fromString($model),
            Details::withDetails(
                $details->getOs(),
                $details->getScreenSize(),
                $details->getScreenResolution(),
                new \DateTimeImmutable($details->getReleasedDate())
            )
        );

        $smartphone = Smartphone::withSpecification(
            SmartphoneId::fromString($smartphoneId),
            $specification
        );

        $this->smartphones->add($smartphone);
    }
}