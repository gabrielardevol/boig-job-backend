<?php

namespace App\Enum;

enum StateEnum: string
{
    case WAITING_FOR_RESPONSE = 'waitingForResponse';
    case IN_PROCESS = 'inProcess';
    case REJECTED = 'rejected';

}
