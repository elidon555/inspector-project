<?php

declare(strict_types=1);

namespace App\Dto\Request;

use Doctrine\DBAL\Types\Types;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CompleteJobRequest
{
    public function __construct(
        #[Assert\Type(type: Types::STRING)]
        #[Assert\Length(max: 255)]
        #[OA\Property(example: 'Interesting notes')]
        public string $note
    ) {
    }
}
