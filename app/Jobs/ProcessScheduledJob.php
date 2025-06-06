<?php

namespace App\Jobs;

use App\Enum\PostStatusEnum;
use App\Models\Post;
use App\Models\PostPlatform;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessScheduledJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels, Dispatchable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $postIds = Post::query()->whereDate('scheduled_time', '<=', now())->pluck('id');

        if ($postIds->isNotEmpty()) {
            PostPlatform::query()->whereIn('post_id', $postIds)
                ->update(['platform_type' => PostStatusEnum::PUBLISHED->value]);

            Post::query()->whereIn('id', $postIds)
                ->update(['status' => PostStatusEnum::PUBLISHED->value]);
        }
    }
}
