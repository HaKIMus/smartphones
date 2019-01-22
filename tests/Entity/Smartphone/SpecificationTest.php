<?php

declare(strict_types=1);

namespace Tests\Model;

use App\Entity\Smartphone\Specification;
use PHPUnit\Framework\TestCase;

class SpecificationTest extends TestCase
{
    /**
     * @expectedException App\Entity\Exception\Smartphone\UnknownCompanyException
     */
    public function testChoosingModelByNotExistingCompany(): void
    {
        Specification::chooseOneFromList('Minifix', 'model');
    }

    /**
     * @expectedException App\Entity\Exception\Smartphone\UnknownModelException
     */
    public function testChoosingModelByNotExistingModel(): void
    {
        Specification::chooseOneFromList(Specification::COMPANIES[0], 'model');
    }
}
