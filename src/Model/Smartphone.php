<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Exception\Smartphone\ReleasedTooLateException;
use App\Model\Smartphone\ReleaseDate;
use App\Model\Smartphone\Id;
use App\Model\Smartphone\Model;

final class Smartphone
{
    const ACCEPTED_RELEASE_DATE = 2012;

    private $id;

    private $model;

    private $releaseDate;

    public static function withSpecification(
        Id $id,
        Model $model,
        ReleaseDate $releaseDate
    ): self {
        if (self::isCompatibleWithAcceptedReleaseDate($releaseDate)) {
            throw new ReleasedTooLateException(sprintf(
                'Smartphone can\'t be released before %s',
                self::ACCEPTED_RELEASE_DATE
            ));
        }

        return new self(
            $id,
            $model,
            $releaseDate
        );
    }

    private function __construct(
        Id $id,
        Model $model,
        ReleaseDate $releaseDate
    ) {
        $this->id = $id;
        $this->model = $model;
        $this->releaseDate = $releaseDate;
    }

    private static function isCompatibleWithAcceptedReleaseDate(ReleaseDate $releaseDate): bool
    {
        $releaseDate = (int) $releaseDate->releaseDate()->format('Y');

        if ($releaseDate < self::ACCEPTED_RELEASE_DATE) {
            return true;
        }

        return false;
    }
}