<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Exception\Smartphone\ReleasedTooLateException;
use App\Entity\Smartphone\ReleaseDate;
use App\Entity\Smartphone\Id;
use App\Entity\Smartphone\Model;
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
                self::MINIMUM_RELEASE_DATE
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

    public function updateSpecification(
        Model $model,
        ReleaseDate $releaseDate
    ): self {
        $updatedSmartphone = new self(
            $this->id,
            $model,
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

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'model' => $this->model,
            'releaseDate' => $this->releaseDate
        ];
    }
}