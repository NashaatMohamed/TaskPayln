<?php

namespace App\Models;

use App\Enum\ActiveEnum;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Platform extends BaseModel
{

    protected $table = 'platforms';

    protected $fillable = [
        'name',
        'type',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', ActiveEnum::ACTIVE->value);
    }


    public function posts():BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_platforms', 'platform_id', 'post_id');
    }
}
