<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Http\Requests\PageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App;

class PageController extends Controller
{
    /**
     * Display a listing of the pages.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->s) {
            $pages = Page::whereTranslation('title', 'like', "%{$request->s}%")->orderBy('created_at', 'desc')->paginate(20);
        } else {
            $pages = Page::orderBy('created_at', 'desc')->paginate(20);
        }

        return response()->json($pages);
    }

    /**
     * Store a newly created page in storage.
     *
     * @param  \App\Http\Requests\PageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        $index = $request->index ? Str::slug($request->index, '_') : Str::slug($request->title, '_');

        $page = Page::create([
            'index' => $index,
            'cover_id' => $request->cover_id,
            'draft' => $request->draft,

            config('app.locale') => [
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
            ],
        ]);

        return response()->json([
            'page' => $page,
            'message' => "The page has been created."
        ]);
    }

    /**
     * Display the specified page.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        $page->load('cover');

        return response()->json($page);
    }

    /**
     * Display the specified page's translation.
     *
     * @param  \App\Page  $page
     * @param  string  $locale
     * @return \Illuminate\Http\Response
     */
    public function getTranslation(Page $page, string $locale)
    {
        $page->load('cover');
        $page->original_title = $page->title;

        App::setLocale($locale);

        return response()->json($page);
    }

    /**
     * Update the specified page in storage.
     *
     * @param  \App\Http\Requests\PageRequest  $request
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, Page $page)
    {
        $page->update([
            'cover_id' => $request->cover_id,
            'draft' => $request->draft,

            config('app.locale') => [
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
            ],
        ]);

        return response()->json("The page has been updated.");
    }

    /**
     * Update the translation of the specified page in storage.
     *
     * @param  \App\Http\Requests\PageRequest  $request
     * @param  \App\Page  $page
     * @param  string  $locale
     * @return \Illuminate\Http\Response
     */
    public function translate(PageRequest $request, Page $page, string $locale)
    {
        $page->update([
            'cover_id' => $request->cover_id,
            'draft' => $request->draft,

            $locale => [
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
            ],
        ]);

        return response()->json("The translation has been updated.");
    }

    /**
     * Remove the specified page from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Page $page)
    {
        $page->delete();

        return response()->json("The page has been deleted.");
    }
}
