<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\storePostRequest;
use App\Models\Platform;
use App\Services\PostService;
use Exception;

class PostController extends Controller
{

    public function __construct(protected PostService $postService)
    {

    }
    public function create()
    {
        $platforms = Platform::query()->get();
        return view('posts.create', get_defined_vars());
    }

    public function store(storePostRequest $request)
    {
        try {
            $post = $this->postService->store($request->validated());
            return redirect()->route('dashboard');
        }catch (Exception $e){
            return back()->with('error', $e->getMessage());
        }

    }
}
