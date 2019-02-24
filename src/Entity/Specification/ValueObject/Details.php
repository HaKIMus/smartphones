<?php

declare(strict_types=1);

namespace App\Entity\Specification\ValueObject;

use App\Entity\Exception\Specification\ReleasedTooLateException;
use App\Entity\ValueObject;

final class Details extends ValueObject implements \JsonSerializable
{
    private const MINIMAL_ACCEPTED_RELEASED_DATE = '01/01/2012';

    private $details;

    private $os;

    private $screenSize;

    private $screenResolution;

    private $releasedDate;

    public static function withDetails(string $os, array $screenSize, array $screenResolution, \DateTimeImmutable $releasedDate): self
    {
        return new self($os, $screenSize, $screenResolution, $releasedDate);
    }

    private function __construct(string $os, array $screenSize, array $screenResolution, \DateTimeImmutable $releasedDate)
    {
        if ($this->isOlderThanAcceptedReleaseDate($releasedDate)) {
            throw new ReleasedTooLateException();
        }

        $this->os = $os;
        $this->screenSize = $screenSize;
        $this->screenResolution = $screenResolution;
        $this->releasedDate = $releasedDate;

        $this->details = [
            'os' => $os,
            'screenSize' => $screenSize,
            'screenResolution' => $screenResolution,
            'releasedDate' => $releasedDate,
        ];
    }

    public function os(): string
    {
        return $this->os;
    }

    public function screenSize(): array
    {
        return $this->screenSize;
    }

    public function screenResolution(): array
    {
        return $this->screenResolution;
    }

    public function releasedDate(): \DateTimeImmutable
    {
        return $this->releasedDate;
    }

    public function details(): array
    {
        return $this->details;
    }

    public function jsonSerialize(): array
    {
        return $this->details;
    }

    private function isOlderThanAcceptedReleaseDate(\DateTimeInterface $releasedDate): bool
    {
        $minimalReleasedDate = new \DateTime(self::MINIMAL_ACCEPTED_RELEASED_DATE);

        if ($releasedDate < $minimalReleasedDate) {
            return true;
        }

        return false;
    }

    public function sameValueAs(ValueObject $valueObject): bool
    {
        $this->instanceOf(get_class($valueObject));

        return $this->os === $valueObject->os
            && $this->screenSize === $valueObject->screenSize
            && $this->screenResolution === $valueObject->screenResolution
            && $this->releasedDate === $valueObject->releasedDate
        ;
    }
}