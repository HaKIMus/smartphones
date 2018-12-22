<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Dbal\Repository\Smartphone;

use App\Model\Smartphone;
use App\Model\Smartphone\Id;
use App\Model\Smartphones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

final class WriteSmartphoneRepository extends ServiceEntityRepository
                                implements Smartphones
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Smartphone::class);
    }

    public function add(Smartphone $smartphone): void
    {
        $this->_em->persist($smartphone);
        $this->_em->flush();
    }

    public function update(Smartphone $smartphone): void
    {
        $this->_em->merge($smartphone);
        $this->_em->flush();
    }

    public function remove(Smartphone $smartphone): void
    {
        $this->_em->remove($smartphone);
        $this->_em->flush();
    }

    public function findById(Id $id): ?Smartphone
    {
        $smartphone = $this->_em->getRepository(Smartphone::class)->findOneBy([
            'id' => (string) $id
        ]);

        return $smartphone;
    }

    /**
     * @return null|array|Smartphone[]
     */
    public function findAll(): ?array
    {
        $smartphones = $this->_em->getRepository(Smartphone::class)->findAll();

        return $smartphones;
    }
}