<?php

declare(strict_types=1);

namespace Tests\Application\Handler;

use App\Application\Command\UpdateSmartphoneCommand;
use App\Application\Dto\SpecificationAttachedToSmartphone;
use App\Application\Handler\UpdateSmartphoneHandler;
use App\Entity\Specification;
use App\Infrastructure\Doctrine\Dbal\Repository\Smartphone\WriteSmartphoneRepository;
use App\Entity\Smartphone;
use App\Entity\Smartphone\Id;
use PHPUnit\Framework\TestCase;

class UpdateSmartphoneHandlerTest extends TestCase
{
    public function testHandle(): void
    {
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


        $specificationDto = new SpecificationAttachedToSmartphone(
            Specification\Company::COMPANY_MYPHONE,
            'Despacito',
            'Saj O\' Es',
            [],
            [],
            '2015-03-12'
        );

        $command = new UpdateSmartphoneCommand(
            (string) Id::generate(),
            $specificationDto
        );

        $handler = new UpdateSmartphoneHandler($smartphoneRepository);

        $handler->handle($command);

        $this->assertTrue(true, 'No need for assertion');
    }
}
