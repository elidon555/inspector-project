<?php

declare(strict_types=1);

namespace App\Enum;

enum JobStatus: string
{
    case ASSIGNED = 'assigned';
    case NEW = 'new';
}
