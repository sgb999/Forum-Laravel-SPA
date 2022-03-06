<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentEditRequest;
use App\Http\Requests\CommentStoreRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($id)
    {
        return response()->json(
            Comment::with('user:id,username')
                    ->select('id', 'comment', 'user_id', 'created_at')
                    ->where('post_id', $id)
                    ->orderBy('created_at', 'ASC')
                    ->paginate(5)
        );
    }

    public function store(CommentStoreRequest $request)
    {
        $validated = $request->validated();
        Comment::create([
            'comment' => $validated['comment'],
            'post_id' => $validated['post_id'],
            'user_id' => auth()->id()
        ]);
        return back();
    }

    public function edit(Comment $comment, CommentEditRequest $request)
    {
        abort_if($comment->user_id != auth()->id(), 403);
        $validated = $request->validated();
        $comment->comment = $validated['comment'];
        $comment->save();
        return back();
    }

    public function destroy(Comment $comment)
    {
        abort_if($comment->user_id != auth()->id(), 403);
        $comment->delete();
        return back();
    }
}
