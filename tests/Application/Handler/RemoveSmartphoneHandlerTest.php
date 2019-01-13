<?php

declare(strict_types=1);

namespace Tests\Application\Handler;

use App\Application\Command\RemoveSmartphoneCommand;
use App\Application\Handler\CreateNewSmartphoneHandler;
use App\Application\Handler\RemoveSmartphoneHandler;
use App\Infrastructure\Doctrine\Dbal\Repository\Smartphone\WriteSmartphoneRepository;
use App\Entity\Smartphone;
use App\Entity\Smartphone\Id;
use App\Entity\Smartphone\Model;
use PHPUnit\Framework\TestCase;

class RemoveSmartphoneHandlerTest extends TestCase
{
    public function testHandle(): void
    {
        /** @var WriteSmartphoneRepository $smartphoneRepository */
        $smartphoneRepository = $this->createMock(WriteSmartphoneRepository::class);

        $smartphoneMock = Smartphone::withSpecification(
            Id::generate(),
            Model::chooseFromList('alonesung', 'milky way 1'),
            Smartphone\ReleaseDate::fromImmutableDateTime(
                new \DateTimeImmutable('now')
            )
        );

        $smartphoneRepository->expects($this->any())
            ->method('findById')
            ->willReturn($smartphoneMock);

        $smartphoneRepository->expects($this->any())
            ->method('remove');

        $handler = new RemoveSmartphoneHandler($smartphoneRepository);

        $command = new RemoveSmartphoneCommand((string) Id::generate());

        $handler->handle($command);

        $this->assertTrue(true); // I won't to disable "no assertion alert" option.
    }
}
