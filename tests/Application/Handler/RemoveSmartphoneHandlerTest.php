<?php

declare(strict_types=1);

namespace Tests\Application\Handler;

use App\Application\Command\RemoveSmartphoneCommand;
use App\Application\Command\Smartphone\IdCommand;
use App\Application\Handler\RemoveSmartphoneHandler;
use App\Entity\Specification;
use App\Infrastructure\Doctrine\Dbal\Repository\Smartphone\WriteSmartphoneRepository;
use App\Entity\Smartphone;
use App\Entity\Smartphone\Id;
use PHPUnit\Framework\TestCase;

class RemoveSmartphoneHandlerTest extends TestCase
{
    public function testHandle(): void
    {
        /** @var WriteSmartphoneRepository $smartphoneRepository */
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
            ->method('remove');

        $handler = new RemoveSmartphoneHandler($smartphoneRepository);

        $command = new RemoveSmartphoneCommand(new IdCommand((string) Id::generate()));

        $handler->handle($command);

        $this->assertTrue(true, 'No need for assertion');
    }
}
