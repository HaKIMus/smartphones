<?php

declare(strict_types=1);

namespace Tests\Model;

use App\Model\Smartphone;
use App\Model\Smartphone\ReleaseDate;
use App\Model\Smartphone\Id;
use App\Model\Smartphone\Model;
use PHPUnit\Framework\TestCase;

class SmartphoneTest extends TestCase
{
    /**
     * @expectedException App\Model\Exception\Smartphone\ReleasedTooLateException
     */
    public function testSmartphoneCantBeProducedBefore2012(): void
    {
        Smartphone::withSpecification(
            Id::generate(),
            Model::chooseFromList('ALONESUNG', 'MILKY WAY 1'),
            ReleaseDate::fromImmutableDateTime(\DateTimeImmutable::createFromFormat('d-m-Y', '16-06-2011'))
        );
    }
}
