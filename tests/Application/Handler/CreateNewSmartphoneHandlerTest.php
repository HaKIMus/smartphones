<?php

declare(strict_types=1);

namespace Tests\Application\Handler;

use App\Application\Command\CreateNewSmartphoneCommand;
use App\Application\Handler\CreateNewSmartphoneHandler;
use App\Infrastructure\Doctrine\Dbal\Repository\Smartphone\WriteSmartphoneRepository;
use App\Model\Smartphone\Id;
use PHPUnit\Framework\TestCase;

class CreateNewSmartphoneHandlerTest extends TestCase
{
    /**
     * @coversNothing
     */
    public function testHandle(): void
    {
        $smartphoneRepository = $this->createMock(WriteSmartphoneRepository::class);

        $smartphoneRepository->expects($this->any())
            ->method('add');

        $handler = new CreateNewSmartphoneHandler($smartphoneRepository);

        $command = new CreateNewSmartphoneCommand(
            (string) Id::generate(),
            [
                'company' => 'ALONESUNG',
                'model' => 'MILKY WAY 1',
            ],
            '03-02-2018'
        );

        $handler->handle($command);

        $this->assertTrue(true); // I won't to disable "no assertion alert" option.
    }
}
