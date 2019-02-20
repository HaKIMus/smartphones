<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Command\UpdateSmartphoneCommand;
use App\Entity\Smartphone;
use App\Entity\Smartphone\Id;
use App\Entity\Smartphones;
use App\Entity\Specification;
use Doctrine\ORM\EntityManagerInterface;

final class UpdateSmartphoneHandler
{
    private $smartphones;

    private $entityManager;

    public function __construct(Smartphones $smartphones, EntityManagerInterface $entityManager)
    {
        $this->smartphones = $smartphones;
        $this->entityManager = $entityManager;
    }

    public function handle(UpdateSmartphoneCommand $command): void
    {
        $specificationCommand = $command->getSpecification();

        $smartphoneId = $command->getSmartphone()->getId()->getId();

        $company = $specificationCommand->getCompany()->getCompany();
        $model = $specificationCommand->getModel()->getModel();
        $details = $specificationCommand->getDetails();

        $smartphone = $this->smartphones->findById(Id::fromString($smartphoneId));

        $company = Specification\Company::fromList($company);
        $model = Specification\Model::fromString($model);
        $details = Specification\Details::withDetails(
            $details->getOs(),
            $details->getScreenSize(),
            $details->getScreenResolution(),
            new \DateTimeImmutable($details->getReleasedDate())
        );

        $specification = $smartphone->specification();

        $specification->changeDetails($details);
        $specification->changeModel($model);
        $specification->changeCompany($company);

        $this->entityManager->flush();
    }
}