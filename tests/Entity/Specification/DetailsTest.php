<?php

namespace Tests\Entity\Specification;

use App\Entity\Exception\Specification\ReleasedTooLateException;
use App\Entity\Specification\ValueObject\Details;
use PHPUnit\Framework\TestCase;

final class DetailsTest extends TestCase
{
    public function testItShouldBeImmutable(): void
    {
        $details = Details::withDetails('SoS', [], [], new \DateTimeImmutable('now'));

        $detailsWithChangedReleasedDate = $details->changeReleasedDate(new \DateTimeImmutable('06-02-2012'));

        $this->assertFalse($details->sameValueAs($detailsWithChangedReleasedDate));
    }

    public function testItThrowsExceptionIfSmartphoneIsCreatedBeforeMinimalAcceptedDate(): void
    {
        $this->expectException(ReleasedTooLateException::class);

        Details::withDetails('', [], [], new \DateTimeImmutable('01-01-2000'));
    }
}