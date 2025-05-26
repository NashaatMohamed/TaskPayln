<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostPlatform extends Model
{

    protected $table = 'post_platforms';

    protected $fillable = [
        'post_id',
        'platform_id',
        "platform_type"
    ];

    public function post():BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function platform():BelongsTo
    {
        return $this->belongsTo(Platform::class, 'platform_id');
    }
}
