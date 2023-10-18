<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([]);

        Post::create($request->all());

        return redirect('/posts')->with('success', 'Post Created Successfully.');
    }

    public function show($id)
    {
        try {
            $post = Post::findOrFail($id);
            return view('posts.show', compact('post'));
        } catch (ModelNotFoundException) {
            return redirect('/posts')->with('error', 'Post Not Found');
        }
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            // ... (ваші правила валідації)
        ]);

        $post = Post::findOrFail($id);
        $this->authorize('update', $post);

        $post->update($request->all());

        return redirect('/posts')->with('success', 'Post Updated Successfully.');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('delete', $post);

        $post->delete();

        return redirect('/posts')->with('success', 'Post Deleted Successfully.');
    }
}
