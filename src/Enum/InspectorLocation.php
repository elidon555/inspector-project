<?php

declare(strict_types=1);

namespace App\Enum;

enum InspectorLocation: string
{
    case TOKYO = 'tokyo';
    case BERLIN = 'berlin';
    case SYDNEY = 'sydney';
    case NEW_YORK = 'new_york';
    case LONDON = 'london';
    case PARIS = 'paris';
}
