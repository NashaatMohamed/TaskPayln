<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $posts = Post::with(['user', 'platforms'])->get();
        return view('dashboard.index',get_defined_vars());
    }
}
