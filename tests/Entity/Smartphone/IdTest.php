<?php

declare(strict_types=1);

namespace Tests\Model\Smartphone;

use App\Entity\Smartphone\ValueObject\Id;
use PHPUnit\Framework\TestCase;

class IdTest extends TestCase
{
    public function testGeneratedIdShouldBeUnique(): void
    {
        $firstId = Id::generate();
        $secondId = Id::generate();

        $this->assertNotEquals($firstId, $secondId);
    }
}
