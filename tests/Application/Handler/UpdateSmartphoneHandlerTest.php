<?php

declare(strict_types=1);

namespace Tests\Application\Handler;

use App\Application\Command\Smartphone\IdCommand as SmartphoneIdCommand;
use App\Application\Command\Smartphone\SmartphoneCommand;
use App\Application\Command\Specification\CompanyCommand;
use App\Application\Command\Specification\DetailsCommand;
use App\Application\Command\Specification\IdCommand as SpecificationIdCommand;
use App\Application\Command\Specification\ModelCommand;
use App\Application\Command\Specification\SpecificationCommand;
use App\Application\Command\UpdateSmartphoneCommand;
use App\Application\Handler\UpdateSmartphoneHandler;
use App\Entity\Smartphone;
use App\Entity\Smartphone\Id;
use App\Entity\Specification;
use App\Infrastructure\Doctrine\Dbal\Repository\Smartphone\WriteSmartphoneRepository;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class UpdateSmartphoneHandlerTest extends TestCase
{
    public function testHandle(): void
    {
        $entityManager = $this->createMock(EntityManager::class);
        $smartphoneRepository = $this->createMock(WriteSmartphoneRepository::class);

        $specification = new Specification(
            Specification\Id::generate(),
            Specification\Company::fromList(Specification\Company::COMPANY_ALONESONG),
            Specification\Model::fromString('Test'),
            Specification\Details::withDetails(
                'SoS',
                [],
                [],
                new \DateTimeImmutable('now')
            )
        );

        $smartphoneMock = Smartphone::withSpecification(
            Id::generate(),
            $specification
        );

        $smartphoneRepository->expects($this->any())
            ->method('findById')
            ->willReturn($smartphoneMock);

        $smartphoneRepository->expects($this->any())
            ->method('update');


        $specificationCommand = new SpecificationCommand(
            new SpecificationIdCommand((string) Id::generate()),
            new CompanyCommand('alonesung'),
            new ModelCommand('milky way 2'),
            new DetailsCommand('SoS', [], [],'2016-02-04')
        );

        $smartphoneCommand = new SmartphoneCommand(
            new SmartphoneIdCommand((string) Id::generate()),
            $specificationCommand
        );

        $command = new UpdateSmartphoneCommand(
            $smartphoneCommand,
            $specificationCommand
        );

        $handler = new UpdateSmartphoneHandler($smartphoneRepository, $entityManager);

        $handler->handle($command);

        $this->assertTrue(true, 'No need for assertion');
    }
}
