<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Exception\Smartphone\ReleasedTooLateException;
use App\Entity\Smartphone\ReleaseDate;
use App\Entity\Smartphone\Id;
use App\Entity\Smartphone\Specification;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="smartphones")
 * @ORM\Entity(repositoryClass="App\Infrastructure\Doctrine\Dbal\Repository\Smartphone\WriteSmartphoneRepository")
 */
final class Smartphone implements \JsonSerializable
{
    const MINIMUM_RELEASE_DATE = 2012;

    /**
     * @var Id
     *
     * @ORM\Id
     * @ORM\Column(type="smartphone_id", unique=true)
     */
    private $id;

    /**
     * @var Specification
     *
     * @ORM\Column(type="json")
     */
    private $specification;

    /**
     * @var ReleaseDate
     *
     * @ORM\Column(type="string")
     */
    private $releaseDate;

    public static function withSpecification(
        Id $id,
        Specification $specification,
        ReleaseDate $releaseDate
    ): self {
        if (self::isCompatibleWithAcceptedReleaseDate($releaseDate)) {
            throw new ReleasedTooLateException(sprintf(
                'SmartphoneQuery can\'t be released before %s',
                self::MINIMUM_RELEASE_DATE
            ));
        }

        return new self(
            $id,
            $specification,
            $releaseDate
        );
    }

    private function __construct(
        Id $id,
        Specification $specification,
        ReleaseDate $releaseDate
    ) {
        $this->id = $id;
        $this->specification = $specification;
        $this->releaseDate = $releaseDate;
    }

    public function updateSpecification(
        Specification $specification,
        ReleaseDate $releaseDate
    ): self {
        $updatedSmartphone = new self(
            $this->id,
            $specification,
            $releaseDate
        );

        return $updatedSmartphone;
    }

    private static function isCompatibleWithAcceptedReleaseDate(ReleaseDate $releaseDate): bool
    {
        $releaseDate = (int) $releaseDate->releaseDate()->format('Y');

        if ($releaseDate < self::MINIMUM_RELEASE_DATE) {
            return true;
        }

        return false;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'specification' => $this->specification,
            'releaseDate' => $this->releaseDate
        ];
    }
}