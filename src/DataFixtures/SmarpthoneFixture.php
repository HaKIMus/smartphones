<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Smartphone\Smartphone;
use App\Entity\Smartphone\ValueObject\Id;
use App\Entity\Specification\ValueObject\Company;
use App\Entity\Specification\ValueObject\Details;
use App\Entity\Specification\ValueObject\Id as SpecificationId;
use App\Entity\Specification\Specification;
use App\Entity\Specification\ValueObject\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SmarpthoneFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $smartphone = Smartphone::withSpecification(
                Id::generate(),
                new Specification(
                    SpecificationId::generate(),
                    Company::fromString('alonesung'),
                    Model::fromString('Milky Way 2'),
                    Details::withDetails('SoS', [], [], new \DateTimeImmutable('now'))
                )
            );

            $manager->persist($smartphone);
        }

        $manager->flush();
    }
}