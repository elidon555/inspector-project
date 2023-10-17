<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Job;
use App\Enum\JobStatus;

class JobFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getSampleData() as $data) {
            $job = (new Job())
                ->setStatus($data['status'])
                ->setDescription($data['description']);

            $manager->persist($job);
        }

        $manager->flush();
    }

    private function getSampleData(): array
    {
        return [
            [
                'description' => 'Develop new features for user-centric mobile application.',
                'status' => JobStatus::ASSIGNED,
            ],
            [
                'description' => 'Design modern, responsive layouts for digital platforms.',
                'status' => JobStatus::NEW,
            ],
            [
                'description' => 'Direct customer service with a focus on satisfaction.',
                'status' => JobStatus::ASSIGNED,
            ],
            [
                'description' => 'Oversee regional sales team performance metric.',
                'status' => JobStatus::NEW,
            ],
            [
                'description' => 'Maintain company social media presence and engagement.',
                'status' => JobStatus::NEW,
            ],
        ];
    }
}
