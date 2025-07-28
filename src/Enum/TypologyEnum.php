<?php

namespace App\Enum;

enum TypologyEnum: string
{
    case REMOTE = 'remote';
    case HYBRID = 'hybrid';
    case ONSITE = 'onsite';
}
