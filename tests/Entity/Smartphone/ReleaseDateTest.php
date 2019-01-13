<?php

declare(strict_types=1);

namespace Tests\Model;

use App\Entity\Smartphone\ReleaseDate;
use PHPUnit\Framework\TestCase;

class ReleaseDateTest extends TestCase
{
    public function testGivenFormatShouldBeDayMonthYear(): void
    {
        $releaseDate = ReleaseDate::fromImmutableDateTime(\DateTimeImmutable::createFromFormat(
            'Y-m-d',
            '2013-02-15'
        ));

        $this->assertSame('15-02-2013', (string) $releaseDate);
    }
}
