<?php

declare(strict_types=1);

namespace App\Model\Smartphone;

final class ReleaseDate
{
    private $releaseDate;

    public static function fromImmutableDateTime(\DateTimeImmutable $dateTime): self
    {
        return new self($dateTime);
    }

    private function __construct(\DateTimeImmutable $releaseDate)
    {
        $this->releaseDate = $releaseDate;
    }

    public function releaseDate(): \DateTimeImmutable
    {
        return $this->releaseDate;
    }

    public function __toString(): string
    {
        return $this->releaseDate->format('d-m-Y');
    }
}