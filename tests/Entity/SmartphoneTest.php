<?php

declare(strict_types=1);

namespace Tests\Model;

use App\Entity\Smartphone;
use App\Entity\Smartphone\ReleaseDate;
use App\Entity\Smartphone\Id;
use App\Entity\Smartphone\Specification;
use PHPUnit\Framework\TestCase;

class SmartphoneTest extends TestCase
{
    /**
     * @expectedException App\Entity\Exception\Smartphone\ReleasedTooLateException
     */
    public function testSmartphoneCantBeProducedBefore2012(): void
    {
        Smartphone::withSpecification(
            Id::generate(),
            Specification::chooseOneFromList('ALONESUNG', 'MILKY WAY 1'),

            ReleaseDate::fromImmutableDateTime(\DateTimeImmutable::createFromFormat('d-m-Y', '16-06-2011'))
        );
    }
}
