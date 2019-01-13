<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Dbal\Repository\Smartphone;

use App\Application\Query\Model\SmartphoneModel;
use App\Application\Query\SmartphoneQuery;
use App\Entity\Smartphone\Id;
use Doctrine\DBAL\Connection;

class ReadSmartphoneRepository implements SmartphoneQuery
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findById(Id $id): ?SmartphoneModel
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select('id', 'specification', 'release_date')
            ->from('smartphones')
            ->where('id = ?')
            ->setParameter(0, (string) $id)
        ;

        $smartphoneData = $this->connection->fetchAssoc(
            $queryBuilder->getSQL(),
            $queryBuilder->getParameters()
        );

        if (!$smartphoneData) {
            return null;
        }

        return new SmartphoneModel(
            $smartphoneData['id'],
            json_decode($smartphoneData['specification'], true),
            $smartphoneData['release_date']
        );
    }

    /**
     * @return null|array|SmartphoneModel[]
     */
    public function findAll(): ?array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select('id', 'specification', 'release_date')
            ->from('smartphones')
        ;

        $smartphonesData = $this->connection->fetchAll(
            $queryBuilder->getSQL(),
            $queryBuilder->getParameters()
        );

        if (!$smartphonesData) {
            return null;
        }

        return array_map(function ($smartphoneData) {
            return new SmartphoneModel(
                $smartphoneData['id'],
                json_decode($smartphoneData['specification'], true),
                $smartphoneData['release_date']
            );
        }, $smartphonesData);
    }
}