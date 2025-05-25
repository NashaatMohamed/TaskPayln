<?php

namespace App\Services;

use App\Models\BaseModel;
use App\Models\Post;
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

        $dailyLimit = $user->posts()->whereDate('scheduled_time', today())->count();
        abort_if($dailyLimit >= 10, 400, 'You have reached your daily limit of 10 posts.');

        $post = Post::query()->create($data + ['user_id' => $user->id]);
        $post->storeImages(media: $data['image']);
        $post->platforms()->sync($data['platforms']);

        return $post;
    }

    public function update(Post $post, array $data): BaseModel
    {
        $post->update($data);

        $post->storeImages(media: $data['image'] ?? null, update: true);

        if (isset($data['platforms'])) {
            $post->platforms()->sync($data['platforms']);
        }

        return $post;
    }

    public function delete(Post $post): void
    {
        $post->delete();
        $post->deleteMedia();
    }
}
