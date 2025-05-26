<?php

namespace App\Jobs;

use App\Enum\PostStatusEnum;
use App\Models\Post;
use Carbon\Carbon;
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
        $posts = Post::query()->whereDate('scheduled_time', "<=", Carbon::now())->get();
        foreach ($posts as $post) {
            $post->platforms()->updateExistingPivot($post->id, ['status' => PostStatusEnum::PUBLISHED->value]);
            $post->update([
                'status' => PostStatusEnum::PUBLISHED->value
            ]);
        }
    }
}
