<?php

declare(strict_types=1);

namespace Tests\Application\Handler;

use App\Application\Command\CreateNewSmartphoneCommand;
use App\Application\Command\Smartphone\IdCommand as SmartphoneIdCommand;
use App\Application\Command\Smartphone\SmartphoneCommand;
use App\Application\Command\Specification\CompanyCommand;
use App\Application\Command\Specification\DetailsCommand;
use App\Application\Command\Specification\IdCommand as SpecificationIdCommand;
use App\Application\Command\Specification\ModelCommand;
use App\Application\Command\Specification\SpecificationCommand;
use App\Application\Handler\CreateNewSmartphoneHandler;
use App\Entity\Smartphone\Id;
use App\Infrastructure\Doctrine\Dbal\Repository\Smartphone\WriteSmartphoneRepository;
use PHPUnit\Framework\TestCase;

class CreateNewSmartphoneHandlerTest extends TestCase
{
    /**
     * @var CreateNewSmartphoneHandler
     */
    private $handler;

    public function setUp(): void
    {
        $smartphoneRepository = $this->createMock(WriteSmartphoneRepository::class);

        $smartphoneRepository->expects($this->any())
            ->method('add');

        $this->handler = new CreateNewSmartphoneHandler($smartphoneRepository);
    }

    public function testHandle(): void
    {
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

        $command = new CreateNewSmartphoneCommand(
            $smartphoneCommand,
            $specificationCommand
        );

        $this->handler->handle($command);
        $this->assertTrue(true, 'No need for assertion');
    }
}
