<?php

namespace App\Enum;

enum ResponseTypeEnum: string
{
    case REJECTION = 'rejection';
    case CONFIRMATION = 'confirmation';
    case INTERVIEW = 'interview';
    case EMPLOYMENT_OFFER = 'employmentOffer';
    case ASSIGNMENT = 'assignment';
}
