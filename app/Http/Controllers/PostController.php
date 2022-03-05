<?php

namespace App\Http\Controllers;
use App\Http\Requests\PostStoreRequest;
use App\Models\{
    Category,
    Post
};

class PostController extends Controller
{
    public function viewTopics($id)
    {
        $url = '/view-topics-ajax/' . $id;
        return inertia('LoadTitles', compact(['url']));
    }

    public function viewPost($id)
    {
        $post = Post::findOrFail($id)
            ->with('user:id,username')
            ->select('id', 'title', 'content', 'user_id', 'created_at', 'category_id')
            ->first();
        return inertia('ViewPost', compact(['post']));
    }

    public function viewTopicsAjax($id)
    {
        return response()->json(
            Post::with('user:id,username', 'category:id,name')
                ->select('id', 'title', 'user_id', 'category_id', 'created_at')
                ->where('category_id', $id)
                ->orderByDesc('created_at')
                ->paginate(20)
        );
    }

    public function postPage()
    {
        $categories = Category::all();
        return inertia('MakePost', compact(['categories']));
    }

    public function updatePostPage(Post $post)
    {
        abort_if($post->user_id !== auth()->id(), 403);
        $categories = Category::all();
        return inertia('updatePost', compact(['post', 'categories']));

    }

    public function store(PostStoreRequest $request)
    {
        $validated = $request->validated();
        $validated += ['user_id' => auth()->id()];
        $post      = Post::create($validated);

        return redirect()->route('viewPost' , $post->id);
    }

    public function edit(PostStoreRequest $request)
    {
        $post = Post::updateOrCreate($request->validated(['user_id' => auth()->id()]));
        return redirect()->route('viewPost' , $post->id);
    }

    public function getProfilePosts($id)
    {
        return response()->json(
            Post::with('user:id,username', 'category:id,name')
                ->select('id', 'title', 'user_id', 'category_id', 'created_at')
                ->where('user_id',  $id)
                ->orderByDesc('created_at')
                ->paginate(10)
        );
    }

    public function destroy(Post $post)
    {
        if($post->user_id !== auth()->id())
        {
            return redirect()->back();
        }
        $id = $post->category_id;
        $post->delete();
        return redirect()->to(route('viewTopics' , $id));
    }
}
