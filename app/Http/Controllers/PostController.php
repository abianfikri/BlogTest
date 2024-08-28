<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('post.index', compact('posts'));
    }

    public function create()
    {
        return view('post.create');
    }

    public function edit(Post $post)
    {
        // Code lebih pendek dan tidak memerlukan else
        if (auth()->user()->id == $post->user_id) {

            return view('post.edit', compact('post'));
        }

        // Bagian Else
        return redirect()->route('post.index')->with('danger', 'You are not authorized to edit this post!');
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|max:255',
        ]);
        $post->update([
            'title' => ucfirst($request->title),
            'content' => ucfirst($request->content),
        ]);
        return redirect()->route('post.index')->with('success', 'post updated successfully!');
    }

    public function store(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|max:255',
        ]);

        $post = Post::create([
            'title' => ucfirst($request->title),
            'content' => ucfirst($request->content),
            'user_id' => auth()->user()->id,

        ]);

        return redirect()->route('post.index')->with('success', 'Post created successfully!');
    }

    public function destroy(Post $post)
    {
        if (auth()->user()->id == $post->user_id) {
            $post->delete();
            return redirect()->route('post.index')->with('success', 'post deleted successfully!');
        }
        return redirect()->route('post.index')->with('danger', 'You are not authorized to delete this post!');
    }
}
