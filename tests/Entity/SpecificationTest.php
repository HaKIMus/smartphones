<?php

declare(strict_types=1);

namespace Tests\Model;

use App\Entity\Specification\Specification;
use App\Entity\Specification\ValueObject\Company;
use App\Entity\Specification\ValueObject\Details;
use App\Entity\Specification\ValueObject\Id;
use App\Entity\Specification\ValueObject\Model;
use PHPUnit\Framework\TestCase;

final class SpecificationTest extends TestCase
{
    public function testConstruction(): void
    {
        new Specification(
            Id::generate(),
            Company::fromList('alonesung'),
            Model::fromString('Milky Way 2'),
            Details::withDetails(
                'SoS',
                ['size' => '14.73', 'unit' => 'cm'],
                ['size' => '1225x2436', 'unit' => 'pixel'],
                new \DateTimeImmutable('now')
            )
        );

        $this->assertTrue(true);
    }
}