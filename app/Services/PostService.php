<?php

namespace App\Services;

use App\Enum\PostStatusEnum;
use App\Models\BaseModel;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class PostService
{


    public function index($request): Collection|LengthAwarePaginator
    {
        $userId = Auth::id();

        $posts = Post::with(['user', 'platforms'])
            ->where('user_id', $userId)
            ->when($request->filled('status'), fn($query) => $query->where('status', $request->status))
            ->when($request->filled('date'), fn($query) => $query->whereDate('created_at', $request->date));

        return $request->filled('perPage')
            ? $posts->paginate($request->perPage)
            : $posts->get();
    }

    public function store(array $data): BaseModel
    {
        $user = Auth::user();

//        $dailyLimit = $user->posts()->whereDate('scheduled_time', today())->count();
        $dailyLimit = $user->posts()->whereDate('created_at', today())->count();
        abort_if($dailyLimit >= 10, 400, 'You have reached your daily limit of 10 posts.');

        $data['status'] = isset($data['scheduled_time']) && $data['scheduled_time'] != null ? PostStatusEnum::SCHEDULED->value : PostStatusEnum::DRAFT->value;
        $post = Post::query()->create($data + ['user_id' => $user->id]);

        $post->platforms()->sync($data['platforms']);
        $post->storeImages(media: $data['image'] ?? null);

        return $post;
    }

    public function update(Post $post, array $data)
    {
        $data['scheduled_time'] = $data['scheduled_time'] ??  $post->scheduled_time ?? now();
        $data['status'] = $post->status === PostStatusEnum::DRAFT->value
            ? PostStatusEnum::SCHEDULED->value
            : $post->status;

        return tap($post, function ($post) use ($data) {
            $post->update($data);
            $post->storeImages(media: $data['image'] ?? null, update: true);
            $post->platforms()?->sync($data['platforms'] ?? []);
        });

    }

    public function delete(Post $post): void
    {
        $post->delete();
        $post->deleteMedia();
    }
}
