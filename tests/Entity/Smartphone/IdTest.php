<?php

declare(strict_types=1);

namespace Tests\Model\Smartphone;

use App\Entity\Smartphone\Id;
use PHPUnit\Framework\TestCase;

class IdTest extends TestCase
{
    public function testGeneratedIdShouldBeUnique(): void
    {
        $firstId = Id::generate();
        $secondId = Id::fromString('123e4567-e89b-12d3-a456-426655440000');

        $this->assertNotSame($firstId, $secondId);
    }
}
