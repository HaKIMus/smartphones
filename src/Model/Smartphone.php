<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Exception\Smartphone\ReleasedTooLateException;
use App\Model\Smartphone\ReleaseDate;
use App\Model\Smartphone\Id;
use App\Model\Smartphone\Model;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="smartphones")
 * @ORM\Entity(repositoryClass="App\Infrastructure\Doctrine\Dbal\Repository\Smartphone\WriteSmartphoneRepository")
 */
final class Smartphone
{
    const ACCEPTED_RELEASE_DATE = 2012;

    /**
     * @var Id
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidOrderedTimeGenerator")
     */
    private $id;

    /**
     * @var Model
     *
     * @ORM\Column(type="json")
     */
    private $model;

    /**
     * @var ReleaseDate
     *
     * @ORM\Column(type="string")
     */
    private $releaseDate;

    public static function withSpecification(
        Id $id,
        Model $model,
        ReleaseDate $releaseDate
    ): self {
        if (self::isCompatibleWithAcceptedReleaseDate($releaseDate)) {
            throw new ReleasedTooLateException(sprintf(
                'SmartphoneQuery can\'t be released before %s',
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