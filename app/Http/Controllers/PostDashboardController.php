<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PostDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->where('author_id', Auth::user()->id);

        if (request('keyword')) {
            $posts = Post::latest()->where('author_id', Auth::user()->id)
                ->where('title', 'like', '%'.request('keyword').'%');
        }

        return view('dashboard.index', [
            'posts' => $posts->paginate(7)->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'title' => 'required|unique:posts|min:4|max:255',
        //     'category_id' => 'required',
        //     'body' => 'required',
        // ]);

        Validator::make($request->all(), [
            'title' => 'required|unique:posts|min:4|max:255',
            'category_id' => 'required',
            'body' => 'required',
        ],
        [
            'title.required' => 'Title is required',
            'category_id.required' => 'Category is required',
            'body.required' => 'Body is required'
        ],
        [
            'title' => 'Title',
            'category_id' => 'Category',
            'body' => 'Body'
        ])->validate();

        // if (validator->fails()) {
        //     return redirect()->back()
        //         ->withErrors($validator)
        //         ->withInput();
        // }

        // Post::create([
        //     'title' => $validated['title'],
        //     'author_id' => Auth::user()->id,
        //     'category_id' => $validated['category_id'],
        //     'slug' => Str::slug($validated['title']),
        //     'body' => $validated['body'],
        // ]);

        return redirect('/dashboard')->with('success', 'New post has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('dashboard.show', [
            'post' => $post,
        ]);
    }
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('dashboard.edit', [
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //validate
        $validated = $request->validate([
            'title' => 'required|min:4|max:255|unique:posts,title' . $post->id,
            'category_id' => 'required',
            'body' => 'required',
        ]);
        //update post
        $post->update([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'slug' => Str::slug($validated['title']),
            'body' => $validated['body'],
        ]);

        //redirect
        return redirect('/dashboard')->with('success', 'Post has been updated!');

        // if ($post->author_id !== Auth::id()) {
        //     abort(403);
        // }

        // $validated = $request->validate([
        //     'title' => [
        //         'required',
        //         'min:4',
        //         'max:255',
        //         Rule::unique('posts', 'title')->ignore($post->id),
        //     ],
        //     'category_id' => 'required',
        //     'body' => 'required',
        // ]);

        // $post->update([
        //     'title' => $validated['title'],
        //     'category_id' => $validated['category_id'],
        //     'slug' => Str::slug($validated['title']),
        //     'body' => $validated['body'],
        // ]);

        // return redirect('/dashboard')->with('success', 'Post has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect('/dashboard')->with('success', 'Post has been deleted!');
    }
}
