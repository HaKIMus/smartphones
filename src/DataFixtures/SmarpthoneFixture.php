<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Smartphone;
use App\Entity\Smartphone\Id;
use App\Entity\Specification;
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
                    Specification\Id::generate(),
                    Specification\Company::fromList('alonesung'),
                    Specification\Model::fromString('Milky Way 2'),
                    Specification\Details::withDetails('SoS', [], [], new \DateTimeImmutable('now'))
                )
            );

            $manager->persist($smartphone);
        }

        $manager->flush();
    }
}