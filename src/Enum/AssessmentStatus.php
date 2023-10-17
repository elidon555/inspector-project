<?php

declare(strict_types=1);

namespace App\Enum;

enum AssessmentStatus: string
{
    case COMPLETED = 'completed';
    case IN_PROGRESS = 'in_progress';

}
