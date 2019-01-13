<?php

declare(strict_types=1);

namespace App\Application\Query\Model;

final class SmartphoneModel implements \JsonSerializable
{
    private $id;

    private $model;

    private $releaseDate;

    public function __construct(
        string $id,
        array $model,
        string $releaseDate
    ) {
        $this->id = $id;
        $this->model = $model;
        $this->releaseDate = $releaseDate;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getModel(): array
    {
        return $this->model;
    }

    public function getReleaseDate(): string
    {
        return $this->releaseDate;
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