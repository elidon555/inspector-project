<?php

declare(strict_types=1);

namespace App\Dto\Response;

use App\Entity\Job;
use JMS\Serializer\Annotation as JMS;
use OpenApi\Attributes as OA;

class JobResponse
{
    #[OA\Property(example: 1)]
    protected ?int $id;

    #[OA\Property(example: 'Work description')]
    protected ?string $description;

    #[OA\Property(example: 'new')]
    protected ?string $status;

    public function __construct(Job $job)
    {
        $this->id = $job->getId();
        $this->description = $job->getDescription();
        $this->status = $job->getStatus();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}