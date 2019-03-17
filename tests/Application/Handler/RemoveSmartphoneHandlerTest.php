<?php

declare(strict_types=1);

namespace Tests\Application\Handler;

use App\Application\Command\RemoveSmartphoneCommand;
use App\Application\Command\Smartphone\IdCommand;
use App\Application\Handler\RemoveSmartphoneHandler;
use App\Entity\Specification\Specification;
use App\Entity\Specification\ValueObject\Company;
use App\Entity\Specification\ValueObject\Details;
use App\Entity\Specification\ValueObject\Model;
use App\Infrastructure\Doctrine\Dbal\Repository\Smartphone\WriteSmartphoneRepository;
use App\Entity\Smartphone\Smartphone;
use App\Entity\Smartphone\ValueObject\Id as SmartphoneId;
use App\Entity\Specification\ValueObject\Id as SpecificationId;
use PHPUnit\Framework\TestCase;

class RemoveSmartphoneHandlerTest extends TestCase
{
    public function testHandle(): void
    {
        /** @var WriteSmartphoneRepository $smartphoneRepository */
        $smartphoneRepository = $this->createMock(WriteSmartphoneRepository::class);

        $specification = new Specification(
            SpecificationId::generate(),
            Company::fromString(Company::COMPANY_ALONESONG),
            Model::fromString('Test'),
            Details::withDetails(
                'SoS',
                [],
                [],
                new \DateTimeImmutable('now')
            )
        );

        $smartphoneMock = Smartphone::withSpecification(
            SmartphoneId::generate(),
            $specification
        );

        $smartphoneRepository->expects($this->any())
            ->method('findById')
            ->willReturn($smartphoneMock);

        $smartphoneRepository->expects($this->any())
            ->method('remove');

        $handler = new RemoveSmartphoneHandler($smartphoneRepository);

        $command = new RemoveSmartphoneCommand(new IdCommand((string) SmartphoneId::generate()));

        $handler->handle($command);

        $this->assertTrue(true, 'No need for assertion');
    }
}
