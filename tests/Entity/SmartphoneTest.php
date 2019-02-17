<?php

declare(strict_types=1);

namespace Tests\Model;

use App\Entity\Exception\Smartphone\ReleasedTooLateException;
use App\Entity\Smartphone;
use App\Entity\Smartphone\Id;
use App\Entity\Specification;
use PHPUnit\Framework\TestCase;

class SmartphoneTest extends TestCase
{
    public function testSmartphoneCantBeProducedBefore2012(): void
    {
        $this->expectException(ReleasedTooLateException::class);

        Smartphone::withSpecification(
            Id::generate(),
            new Specification(
                Specification\Id::generate(),
                Specification\Company::fromList(Specification\Company::COMPANY_ALONESONG),
                Specification\Model::fromString('Milky Way 2'),
                Specification\Details::withDetails('SoS', [], [], new \DateTimeImmutable('01-01-2011'))
            )
        );
    }
}
