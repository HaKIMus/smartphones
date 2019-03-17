<?php

namespace Tests\Entity\Specification;

use App\Entity\Exception\Specification\UnknownCompanyException;
use App\Entity\Specification\ValueObject\Company;
use PHPUnit\Framework\TestCase;

final class CompanyTest extends TestCase
{
    public function testItShouldThrowExceptionIfCompanyIsNotSupported(): void
    {
        $this->expectException(UnknownCompanyException::class);

        Company::fromString('not supported company');
    }

    /**
     * @dataProvider companyConstDataProvider
     */
    public function testYouCanCreateCompanyFromConst(string $companyConst): void
    {
        $company = Company::fromString($companyConst);

        $this->assertEquals($companyConst, (string) $company);
    }

    public function testItShouldBeImmutable(): void
    {
        $company = Company::fromString('Alonesung');

        $renamedCompany = $company->rename('Myphone');

        $this->assertFalse(
            $company->sameValueAs($renamedCompany)
        );
    }

    public function companyConstDataProvider(): array
    {
        return [
            [Company::COMPANY_ALONESONG, Company::COMPANY_MYPHONE, Company::COMPANY_SHAOLIN]
        ];
    }
}