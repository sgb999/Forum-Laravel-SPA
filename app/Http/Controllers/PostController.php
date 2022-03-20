<?php

namespace App\Http\Controllers;
use App\Http\Requests\PostStoreRequest;
use App\Models\{
    Category,
    Post
};

class PostController extends Controller
{

    public function index()
    {
        return inertia('home', [ 'url' => '/view-all-topics/' ]);
    }

    public function viewAllTopics()
    {
        return response()->json(
            Post::with('user:id,username', 'category:id,name')
                ->select('id', 'title', 'user_id', 'category_id', 'created_at')
                ->orderByDesc('created_at')
                ->paginate(20)
        );
    }

    public function viewTopics($id)
    {
        return inertia('LoadTitles', [ 'url' => '/view-topics-ajax/' . $id ]);
    }

    public function viewPost($id)
    {
        return inertia('ViewPost', ['post' => Post::whereId($id)
            ->with(['user' => function ($query){
               $query->with('media')
                     ->select('id', 'username');
            }])
            ->select('id', 'title', 'content', 'user_id', 'created_at', 'category_id')
            ->first()]);
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
        return inertia('MakePost', [ 'categories' => Category::all()]);
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

        return redirect()->route('post.show' , $post->id);
    }

    public function edit(Post $post, PostStoreRequest $request)
    {
        abort_unless($post->user_id == auth()->id(), 403);
        $validated = $request->validated();
        $post->update($validated);
        $post->save();

        return $this->viewPost($post->id);
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
        abort_unless($post->user_id == auth()->id(), 403);
        $id = $post->category_id;
        $post->delete();
        return $this->viewTopics($id);
    }
}
