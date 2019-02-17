<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Dbal\Repository\Specification;

use App\Entity\Specification;
use App\Entity\Specification\Id;
use App\Entity\Specifications;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class WriteSpecificationRepository extends ServiceEntityRepository
                                    implements Specifications
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Specification::class);
    }

    public function add(Specification $specification): void
    {
        $this->_em->persist($specification);
        $this->_em->flush();
    }

    public function update(Specification $specification): void
    {
        $this->_em->merge($specification);
        $this->_em->flush();
    }

    public function remove(Specification $specification): void
    {
        $this->_em->remove($specification);
        $this->_em->flush();
    }

    public function findById(Id $id): ?Specification
    {
        $specification = $this->_em->getRepository(Specification::class)->findOneBy([
            'id' => (string) $id
        ]);

        return $specification;
    }

    /**
     * @return null|array|Specification[]
     */
    public function findAll(): ?array
    {
        $specifications = $this->_em->getRepository(Specification::class)->findAll();

        return $specifications;
    }
}