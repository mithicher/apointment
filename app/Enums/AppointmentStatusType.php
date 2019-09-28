<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class AppointmentStatusType extends Enum
{
    const Pending = 0;
    const Approved = 1;
    const Complete = 2;
}
