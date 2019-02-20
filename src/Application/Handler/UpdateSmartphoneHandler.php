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

        $specification = $smartphone->specification();

        $specification->changeDetails($details);
        $specification->changeModel($model);
        $specification->changeCompany($company);

        $this->entityManager->flush();
    }
}