<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Inspector;
use App\Enum\InspectorLocation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class InspectorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getSampleData() as $data) {
            $inspector = (new Inspector())
                ->setName($data['name'])
                ->setLocation($data['location']);

            $manager->persist($inspector);
        }

        $manager->flush();
    }

    private function getSampleData(): array
    {
        return [
            [
                'name' => 'Tommy',
                'location' => InspectorLocation::BERLIN,
            ],
            [
                'name' => 'Patrick',
                'location' => InspectorLocation::SYDNEY,
            ],
            [
                'name' => 'Jackson',
                'location' => InspectorLocation::TOKYO,
            ],
            [
                'name' => 'Benn',
                'location' => InspectorLocation::LONDON,
            ],
            [
                'name' => 'Ann',
                'location' => InspectorLocation::PARIS,
            ],
        ];
    }
}
