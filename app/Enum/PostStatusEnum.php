<?php

namespace App\Enum;

enum PostStatusEnum :int
{
    case DRAFT = 1;
    case PUBLISHED = 2;
    case SCHEDULED = 3;
    case FAILED = 4;
}
