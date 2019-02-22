<?php

declare(strict_types=1);

namespace App\Application\Command\Specification;

final class DetailsCommand
{
    private $os;

    private $screenSize;

    private $screenResolution;

    private $releasedDate;

    public function __construct(
        string $os,
        array $screenSize,
        array $screenResolution,
        string $releasedDate
    ) {
        $this->os = $os;
        $this->screenSize = $screenSize;
        $this->screenResolution = $screenResolution;
        $this->releasedDate = $releasedDate;
    }

    public function getOs(): string
    {
        return $this->os;
    }

    public function getScreenSize(): array
    {
        return $this->screenSize;
    }

    public function getScreenResolution(): array
    {
        return $this->screenResolution;
    }

    public function getReleasedDate(): string
    {
        return $this->releasedDate;
    }
}