<?php

namespace App\Enum;

enum PlatformTypeEnum : int
{
    case TWITTER = 1; // 280
    case INSTAGRAM = 2; // 5000
    case LINKEDIN = 3; // 1300

    case FACEBOOK = 4;
    case TIKTOK = 5;
}
