<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment; 
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        return Post::with('user', 'comments')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return response()->json($post, 201);
    }

    public function show(Post $post)
    {
        return $post->load('user', 'comments');
    }

    public function update(Request $request, Post $post)
    {
        Gate::authorize('update', $post);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'body' => 'sometimes|string',
        ]);

        $post->update($request->only('title', 'body'));

        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return response()->json(null, 204);
    }
}