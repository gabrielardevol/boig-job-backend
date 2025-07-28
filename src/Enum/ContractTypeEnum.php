<?php
// src/Enum/ContractTypeEnum.php

namespace App\Enum;

enum ContractTypeEnum: string
{
    case PERMANENT = 'permanent';
    case TEMPORARY = 'temporary';
    case PART_TIME = 'part-time';
    case FULL_TIME = 'full-time';
    case INTERNSHIP = 'internship';
    case FREELANCE = 'freelance';
    case PROJECT_BASED = 'project-based';
    case CONSULTANT = 'consultant';
}
