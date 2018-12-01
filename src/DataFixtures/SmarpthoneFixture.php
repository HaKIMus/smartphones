<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Model\Smartphone;
use App\Model\Smartphone\Id;
use App\Model\Smartphone\Model;
use App\Model\Smartphone\ReleaseDate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SmarpthoneFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $smartphone = Smartphone::withSpecification(
                Id::generate(),
                Model::chooseFromList(
                    'alonesung',
                    'milky way 1'
                ),
                ReleaseDate::fromImmutableDateTime(
                    new \DateTimeImmutable('now')
                )
            );

            $manager->persist($smartphone);
        }

        $manager->flush();
    }
}