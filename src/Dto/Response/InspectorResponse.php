<?php

declare(strict_types=1);

namespace App\Dto\Response;

use App\Entity\Inspector;
use OpenApi\Attributes as OA;

class InspectorResponse
{
    #[OA\Property(example: 3)]
    protected ?int $id;

    #[OA\Property(example: 'Jackson')]
    protected ?string $name;

    #[OA\Property(example: 'Tokyo')]
    protected ?string $location;

    public function __construct(Inspector $inspector)
    {
        $this->id = $inspector->getId();
        $this->name = $inspector->getName();
        $this->location = $inspector->getLocation();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLocation(): string
    {
        return $this->location;
    }
}