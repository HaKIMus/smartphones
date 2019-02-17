<?php

declare(strict_types=1);

namespace Tests\Application\Handler;

use App\Application\Command\CreateNewSmartphoneCommand;
use App\Application\Dto\SpecificationAttachedToSmartphone;
use App\Application\Handler\CreateNewSmartphoneHandler;
use App\Entity\Specification\Company;
use App\Infrastructure\Doctrine\Dbal\Repository\Smartphone\WriteSmartphoneRepository;
use App\Entity\Smartphone\Id;
use PHPUnit\Framework\TestCase;

class CreateNewSmartphoneHandlerTest extends TestCase
{
    public function testHandle(): void
    {
        $smartphoneRepository = $this->createMock(WriteSmartphoneRepository::class);

        $smartphoneRepository->expects($this->any())
            ->method('add');

        $handler = new CreateNewSmartphoneHandler($smartphoneRepository);

        $specificationDto = new SpecificationAttachedToSmartphone(
            'alonesung',
            'milky way 2',
            'SoS',
            [],
            [],
            '2016-02-04'
        );

        $command = new CreateNewSmartphoneCommand(
            (string) Id::generate(),
            $specificationDto
        );

        $handler->handle($command);
        $this->assertTrue(true, 'No need for assertion');
    }
}
