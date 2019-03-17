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
            throw new ReleasedTooLateException(sprintf(
                'Smartphone cannot be added if create before %s',
                self::MINIMAL_ACCEPTED_RELEASED_DATE
            ));
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

    public function changeOs(string $os): self
    {
        return new self($os, $this->screenSize, $this->screenResolution, $this->releasedDate);
    }

    public function changeScreenSize(array $screenSize): self
    {
        return new self($this->os, $screenSize, $this->screenResolution, $this->releasedDate);
    }

    public function changeScreenResolution(array $screenResolution): self
    {
        return new self($this->os, $this->screenSize, $screenResolution, $this->releasedDate);
    }

    public function changeReleasedDate(\DateTimeImmutable $releasedDate): self
    {
        return new self($this->os, $this->screenSize, $this->screenResolution, $releasedDate);
    }

    public function __toString(): string
    {
        return json_encode($this);
    }

    public function jsonSerialize(): array
    {
        return $this->details;
    }

    private function isOlderThanAcceptedReleaseDate(\DateTimeInterface $releasedDate): bool
    {
        $minimalReleasedDate = new \DateTime(self::MINIMAL_ACCEPTED_RELEASED_DATE);

        return $releasedDate < $minimalReleasedDate;
    }

    public function sameValueAs(ValueObject $valueObject): bool
    {
        $this->isInstanceOf($valueObject);

        return $this->os === $valueObject->os
            && $this->screenSize === $valueObject->screenSize
            && $this->screenResolution === $valueObject->screenResolution
            && $this->releasedDate === $valueObject->releasedDate
        ;
    }
}