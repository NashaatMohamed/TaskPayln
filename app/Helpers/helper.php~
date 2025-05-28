<?php

use Carbon\Carbon;

function convertToArray($data): array
{
    return is_array($data) && !empty($data) ? $data : [$data] ?? [];
}

function convertCreatedAt($createdAt = null): ?string
{
    return $createdAt ? Carbon::parse($createdAt)->format('Y-m-d') : null;
}
