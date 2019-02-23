<?php

declare(strict_types=1);

namespace Tests\Model;

use App\Entity\Exception\Specification\ReleasedTooLateException;
use App\Entity\Smartphone\Smartphone;
use App\Entity\Smartphone\ValueObject\Id;
use App\Entity\Specification\Specification;
use App\Entity\Specification\ValueObject\Company;
use App\Entity\Specification\ValueObject\Details;
use App\Entity\Specification\ValueObject\Id as SpecificationId;
use App\Entity\Specification\ValueObject\Model;
use PHPUnit\Framework\TestCase;

class SmartphoneTest extends TestCase
{
    public function testSmartphoneCantBeProducedBefore2012(): void
    {
        $this->expectException(ReleasedTooLateException::class);

        Smartphone::withSpecification(
            Id::generate(),
            new Specification(
                SpecificationId::generate(),
                Company::fromList(Company::COMPANY_ALONESONG),
                Model::fromString('Milky Way 2'),
                Details::withDetails('SoS', [], [], new \DateTimeImmutable('01-01-2011'))
            )
        );
    }
}
