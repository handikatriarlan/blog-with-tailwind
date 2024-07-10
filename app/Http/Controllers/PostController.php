<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'DESC')->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:151',
            'content' => 'required|string',
            'status' => 'required|integer'
        ]);

        $post = Post::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'status' => $validatedData['status'],
            'slug' => Str::slug($validatedData['title'])
        ]);

        return redirect()->route('post.index')
            ->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:151',
            'content' => 'required',
            'status' => 'required|integer'
        ]);

        $post->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'status' => $validatedData['status'],
            'slug' => Str::slug($validatedData['title'])
        ]);

        return redirect()->route('post.index')
            ->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()
            ->route('post.index')
            ->with('success', 'Post deleted successfully.');
    }
}
