<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\storePostRequest;
use App\Http\Requests\Post\updatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psy\Util\Json;

class PostController extends Controller
{

    public function __construct(protected PostService $postService){}

    public function index(Request $request): JsonResponse
    {
        $posts = $this->postService->index(request: $request);
        return $this->dataResponse(msg: 'the posts fetched successfully', data: PostResource::collection($posts));
    }

    public function store(storePostRequest $request) : JsonResponse
    {
        try {
            $post = $this->postService->store($request->validated());

            return $this->dataResponse(msg: 'the post created successfully', data: PostResource::make($post->fresh()));
        } catch (Exception $e) {
            return $this->errorResponse(msg: $e->getMessage(), code: 400);
        }
    }

    public function update(Post $post, updatePostRequest $request) : JsonResponse
    {
        $post = $this->postService->update($post, $request->validated());
        return $this->dataResponse(msg: 'the post updated successfully', data: PostResource::make($post->fresh()));
    }

    public function destroy(Post $post) : JsonResponse
    {
        $this->postService->delete($post);
        return $this->successResponse(msg: "the post deleted successfully");
    }

}
