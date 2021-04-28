<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App;

class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->s) {
            $posts = Post::whereTranslation('title', 'like', "%{$request->s}%")->orderBy('created_at', 'desc')->paginate(20);
        } else {
            $posts = Post::orderBy('created_at', 'desc')->paginate(20);
        }

        return response()->json($posts);
    }

    /**
     * Store a newly created post in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post = Post::create([
            'cover_id' => $request->cover_id,
            'draft' => $request->draft,

            config('app.locale') => [
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'excerpt' => $request->excerpt,
            ],
        ]);

        return response()->json([
            'post' => $post,
            'message' => "The post has been created."
        ]);
    }

    /**
     * Display the specified post.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->load('cover');

        return response()->json($post);
    }

    /**
     * Display the specified post's translation.
     *
     * @param  \App\Post  $post
     * @param  string  $locale
     * @return \Illuminate\Http\Response
     */
    public function getTranslation(Post $post, string $locale)
    {
        $post->load('cover');
        $post->original_title = $post->title;

        App::setLocale($locale);

        return response()->json($post);
    }

    /**
     * Update the specified post in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->update([
            'cover_id' => $request->cover_id,
            'draft' => $request->draft,

            config('app.locale') => [
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'excerpt' => $request->excerpt,
            ],
        ]);

        return response()->json("The post has been updated.");
    }

    /**
     * Update the translation of the specified post in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @param  \App\Post  $post
     * @param  string  $locale
     * @return \Illuminate\Http\Response
     */
    public function translate(PostRequest $request, Post $post, string $locale)
    {
        $post->update([
            'cover_id' => $request->cover_id,
            'draft' => $request->draft,

            $locale => [
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'excerpt' => $request->excerpt,
            ],
        ]);

        return response()->json("The translation has been updated.");
    }

    /**
     * Remove the specified post from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Post $post)
    {
        $post->delete();

        return response()->json("The post has been deleted.");
    }
}
