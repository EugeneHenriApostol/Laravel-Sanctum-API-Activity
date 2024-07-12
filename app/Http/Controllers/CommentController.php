<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    use AuthorizesRequests;
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'body' => 'required|string',
        ]);

        $comment = Comment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        return redirect()->route('feed');
    }

    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('update', $comment);

        $request->validate([
            'body' => 'sometimes|string',
        ]);

        $comment->update($request->only('body'));

        return redirect()->route('feed');
    }

    public function destroy(Comment $comment)
    {
        Gate::authorize('delete', $comment);

        $comment->delete();

        return redirect()->route('feed');
    }
}
