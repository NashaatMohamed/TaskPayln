<?php

namespace App\Http\Controllers\Blade;

use App\Enum\PostStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostPlatform;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{

    public function index()
    {
        {
            $userId = auth()->id();

            $postsPerPlatform = PostPlatform::select('platform_id', DB::raw('COUNT(*) as count'))
                ->whereHas('post', fn ($q) => $q->where('user_id', $userId))
                ->groupBy('platform_id')
                ->with('platform:id,name')
                ->get();

            $statusCounts = [
                'scheduled' => Post::where('user_id', $userId)->where('status', PostStatusEnum::SCHEDULED->value)->count(),
                'published' => Post::where('user_id', $userId)->where('status', PostStatusEnum::PUBLISHED->value)->count(),
            ];

            $dailyCounts = Post::select(DB::raw('DATE(scheduled_time) as date'), DB::raw('COUNT(*) as count'))
                ->where('user_id', $userId)
                ->groupBy(DB::raw('DATE(scheduled_time)'))
                ->orderBy('date')
                ->get();

            return view('dashboard.analytics', get_defined_vars());
        }
    }
}
