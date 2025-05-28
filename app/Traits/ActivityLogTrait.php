<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait ActivityLogTrait
{

    public function logActivity(string $action): void
    {
        ActivityLog::query()->create([
            'user_id' => Auth::id(),
            'action' => $action,
        ]);
    }
}
