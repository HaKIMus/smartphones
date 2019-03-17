<?php

declare(strict_types=1);

namespace Tests\Entity\Specification;

use App\Entity\Smartphone\ValueObject\Id;
use PHPUnit\Framework\TestCase;

class IdTest extends TestCase
{
    public function testGeneratedIdShouldBeUnique(): void
    {
        $firstId = Id::generate();
        $secondId = Id::generate();

        $this->assertFalse($firstId->sameValueAs($secondId));
    }
}
