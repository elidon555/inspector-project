<?php

declare(strict_types=1);

namespace App\Dto\Request;

use DateTime;
use Doctrine\DBAL\Types\Types;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

readonly class AssignJobRequest
{
    public function __construct(
        #[Assert\Type(type: Types::INTEGER)]
        #[Assert\Length(max: 255)]
        #[OA\Property(example: 5)]
        public int    $jobId,

        #[Assert\DateTime(format: 'Y-m-d')]
        #[OA\Property(example: '2000-01-23')]
        public string $deliveryDate,
    ) {
    }
}
