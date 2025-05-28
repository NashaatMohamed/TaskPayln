<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\storePostRequest;
use App\Http\Requests\Post\updatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Platform;
use App\Models\Post;
use App\Services\PostService;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function __construct(protected PostService $postService) {}

    public function index(Request $request)
    {
        $posts = $this->postService->index($request);
        if ($request->ajax()) {
            return response()->json([
                'data' => $posts
            ]);
        }

        return view('dashboard.index',get_defined_vars());
    }
    public function create()
    {
        $platforms = Platform::query()->get();
        return view('posts.create', get_defined_vars());
    }

    public function store(storePostRequest $request)
    {
        try {
            $this->postService->store($request->validated());
            return to_route("dashboard")->with("success", "the post created successfully");
        }catch (Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(Post $post)
    {
        $platforms = Platform::query()->get();

        return view('posts.edit', get_defined_vars());
    }

    public function update(Post $post, updatePostRequest $request)
    {
        try {
            $this->postService->update($post, $request->validated());
            return to_route("dashboard")->with("success", "the post updated successfully");
        }catch (Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Post $post)
    {
        try {
            $this->postService->delete($post);
            return to_route("dashboard")->with("success", "the post deleted successfully");
        }catch (Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
}
