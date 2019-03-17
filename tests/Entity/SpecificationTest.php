<?php

declare(strict_types=1);

namespace Tests\Entity;

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
            Company::fromString('alonesung'),
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

    public function testComparingTwoSpecifications(): void
    {
        $specification = new Specification(
            Id::generate(),
            Company::fromString('alonesung'),
            Model::fromString('Milky Way 2'),
            Details::withDetails(
                'SoS',
                ['size' => '14.73', 'unit' => 'cm'],
                ['size' => '1225x2436', 'unit' => 'pixel'],
                new \DateTimeImmutable('now')
            )
        );

        $specificationToCompare = new Specification(
            Id::generate(),
            Company::fromString('myphone'),
            Model::fromString('Milky Way 2'),
            Details::withDetails(
                'Druid',
                ['size' => '12.73', 'unit' => 'cm'],
                ['size' => '1225x2436', 'unit' => 'pixel'],
                new \DateTimeImmutable('now')
            )
        );

        $specification->compare($specificationToCompare);
    }
}