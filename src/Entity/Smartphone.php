<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Exception\Smartphone\ReleasedTooLateException;
use App\Entity\Smartphone\Id;
use App\Entity\Specification\Company;
use App\Entity\Specification\Details;
use App\Entity\Specification\Model;

final class Smartphone implements \JsonSerializable
{
    private const MINIMAL_ACCEPTED_RELEASED_DATE = '01/01/2012';

    private $id;

    private $specification;

    public static function withSpecification(
        Id $id,
        Specification $specification
    ): self {
        return new self(
            $id,
            $specification
        );
    }

    private function __construct(
        Id $id,
        Specification $specification
    ) {
        if (!$this->isReleasedAfterMinimalAcceptedDate($specification->details()->releasedDate())) {
            throw new ReleasedTooLateException();
        }

        $this->id = $id;
        $this->specification = $specification;
    }

    public function specification(): Specification
    {
        return $this->specification;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'specification' => $this->specification,
        ];
    }

    private function isReleasedAfterMinimalAcceptedDate(\DateTimeInterface $releasedDate): bool
    {
        $minimalReleasedDate = new \DateTime(self::MINIMAL_ACCEPTED_RELEASED_DATE);

        if ($releasedDate >= $minimalReleasedDate) {
            return true;
        }

        return false;
    }
}