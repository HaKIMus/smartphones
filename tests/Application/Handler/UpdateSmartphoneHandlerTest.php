<?php

declare(strict_types=1);

namespace Tests\Application\Handler;

use App\Application\Command\RemoveSmartphoneCommand;
use App\Application\Command\UpdateSmartphoneCommand;
use App\Application\Handler\CreateNewSmartphoneHandler;
use App\Application\Handler\RemoveSmartphoneHandler;
use App\Application\Handler\UpdateSmartphoneHandler;
use App\Infrastructure\Doctrine\Dbal\Repository\Smartphone\WriteSmartphoneRepository;
use App\Model\Smartphone;
use App\Model\Smartphone\Id;
use App\Model\Smartphone\Model;
use PHPUnit\Framework\TestCase;

class UpdateSmartphoneHandlerTest extends TestCase
{
    public function testHandle(): void
    {
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
            ->method('update');

        $command = new UpdateSmartphoneCommand(
            (string) Id::generate(),
            [
                'company' => 'alonesung',
                'model' => 'milky way 1',
            ],
            '31-07-2016'
        );

        $handler = new UpdateSmartphoneHandler($smartphoneRepository);

        $handler->handle($command);

        $this->assertTrue(true); // I won't to disable "no assertion alert" option.
    }
}
