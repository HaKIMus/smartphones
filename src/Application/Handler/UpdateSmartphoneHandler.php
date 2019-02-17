<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Command\UpdateSmartphoneCommand;
use App\Entity\Smartphone;
use App\Entity\Smartphone\Id;
use App\Entity\Smartphones;
use App\Entity\Specification;

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

        $specificationCommand = $command->getSpecification();

        $company = Specification\Company::fromList($specificationCommand->getCompany());
        $model = Specification\Model::fromString($specificationCommand->getModel());
        $details = Specification\Details::withDetails(
            $specificationCommand->getOs(),
            $specificationCommand->getScreenSize(),
            $specificationCommand->getScreenResolution(),
            new \DateTimeImmutable($specificationCommand->getReleasedDate())
        );

        $smartphone->updateSpecification($company, $model, $details);

        $this->smartphones->update($smartphone);
    }
}