<?php

namespace Tests\Entity\Specification;

use App\Entity\Exception\Specification\UnknownCompanyException;
use App\Entity\Specification\ValueObject\Company;
use App\Entity\Specification\ValueObject\Model;
use PHPUnit\Framework\TestCase;

final class ModelTest extends TestCase
{
    public function testItShouldBeImmutable(): void
    {
        $company = Model::fromString('1');

        $renamedCompany = $company->changeModel('2');

        $this->assertFalse(
            $company->sameValueAs($renamedCompany)
        );
    }
}