<?php

declare(strict_types=1);

namespace Tests\Model;

use App\Entity\Specification;
use PHPUnit\Framework\TestCase;

final class SpecificationTest extends TestCase
{
    public function testConstruction(): void
    {
        new Specification(
            Specification\Id::generate(),
            Specification\Company::fromList('alonesung'),
            Specification\Model::fromString('Milky Way 2'),
            Specification\Details::withDetails(
                'SoS',
                ['size' => '14.73', 'unit' => 'cm'],
                ['size' => '1225x2436', 'unit' => 'pixel'],
                new \DateTimeImmutable('now')
            )
        );

        $this->assertTrue(true);
    }
}