<?php

namespace App\Models;

use App\Traits\ActivityLogTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends BaseModel
{

    use ActivityLogTrait;
    protected $table = 'posts';

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'scheduled_time',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function platforms(): BelongsToMany
    {
        return $this->belongsToMany(Platform::class, 'post_platforms', 'post_id', 'platform_id');
    }

    protected static function booted(): void
    {
        static::created(function ($post) {
            $post->logActivity("Created post: '{$post->title}'");
        });

        static::updated(function ($post) {
            $changed = collect($post->getChanges())->keys()->implode(', ');
            $post->logActivity("Updated post '{$post->title}' (Changed: {$changed})");
        });


        static::deleted(function ($post) {
            $post->logActivity("Deleted post: '{$post->title}'");
        });
    }


}
