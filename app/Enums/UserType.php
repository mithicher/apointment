<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserType extends Enum
{
    const Administrator = 0;
    const Owner = 1;
    const Manager = 2;
    const Client = 3;
}
