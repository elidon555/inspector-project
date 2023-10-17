<?php

declare(strict_types=1);

namespace App\Dto\Response;

use App\Dto\Response\InspectorResponse;
use App\Dto\Response\JobResponse;
use DateTimeInterface;
use OpenApi\Attributes as OA;

class AssessmentResponse
{
    #[OA\Property(example: 3)]
    private int $id;

    #[OA\Property(example: [['id' => 5, 'name' => 'Jackson', 'location' => 'Tokyo']])]
    private InspectorResponse $inspector;

    #[OA\Property(example: [['id' => 3, 'description' => 'Some work description', 'status' => 'new']])]
    private JobResponse $job;

    #[OA\Property(example: '2000-01-23')]
    private DateTimeInterface $assignedDate;

    #[OA\Property(example: '2000-01-23')]
    private DateTimeInterface $deliveryDate;

    #[OA\Property(example: 'Note about the job when finished.')]
    private string $note;

    public function __construct(
        int $id,
        InspectorResponse $inspector,
        JobResponse $job,
        DateTimeInterface $assignedDate,
        DateTimeInterface $deliveryDate,
        string $note
    ) {
        $this->id = $id;
        $this->inspector = $inspector;
        $this->job = $job;
        $this->assignedDate = $assignedDate;
        $this->deliveryDate = $deliveryDate;
        $this->note = $note;
    }

    // Getters for the properties. We don't need setters if the object is immutable.

    public function getId(): int
    {
        return $this->id;
    }

    public function getInspector(): InspectorResponse
    {
        return $this->inspector;
    }

    public function getJob(): JobResponse
    {
        return $this->job;
    }

    public function getAssignedDate(): DateTimeInterface
    {
        return $this->assignedDate;
    }

    public function getDeliveryDate(): DateTimeInterface
    {
        return $this->deliveryDate;
    }

    public function getNote(): string
    {
        return $this->note;
    }
}
