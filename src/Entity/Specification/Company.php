<?php

declare(strict_types=1);

namespace App\Entity\Specification;

use App\Entity\Exception\Specification\UnknownCompanyException;

final class Company implements \JsonSerializable
{
    public const COMPANY_ALONESONG = 'ALONESUNG';
    public const COMPANY_MYPHONE = 'MYPHONE';
    public const COMPANY_SHAOLIN = 'SHAOLIN';

    private const COMPANIES = [
        self::COMPANY_ALONESONG,
        self::COMPANY_MYPHONE,
        self::COMPANY_SHAOLIN,
    ];

    private $company;

    public static function fromList(string $company): self
    {
        return new self($company);
    }

    private function __construct(string $company)
    {
        $company = mb_strtoupper($company);

        if (!$this->givenCompanyExist($company)) {
            throw new UnknownCompanyException(sprintf(
                'No company with name %s',
                $company
            ));
        }

        $this->company = $company;
    }

    public function jsonSerialize(): array
    {
        return [
            'company' => $this->company,
        ];
    }

    private function givenCompanyExist(string $company): bool
    {
        if (in_array($company, self::COMPANIES)) {
            return true;
        }

        return false;
    }
}