<?php

declare(strict_types=1);

namespace App\Entity\Specification;

final class Details implements \JsonSerializable
{
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
}