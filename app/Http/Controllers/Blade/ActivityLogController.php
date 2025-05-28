<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{

    public function index()
    {
        $logs = ActivityLog::with('user:id,name')
            ->where('user_id', auth()->id())
            ->latest()
            ->take(50)
            ->get();

        return view('dashboard.activity_logs', get_defined_vars());
    }
}
