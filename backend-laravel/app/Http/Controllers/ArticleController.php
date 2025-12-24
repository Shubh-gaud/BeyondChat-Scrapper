<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArticleController extends Controller
{
    /**
     * Display a listing of the articles.
     */
    public function index()
    {
        return response()->json(
            Article::orderBy('created_at', 'desc')->get(),
            Response::HTTP_OK
        );
    }

    /**
     * Store a newly created article in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'source_url'  => 'required|url',
            'type'        => 'required|in:original,updated',
            'references'  => 'nullable|array',
        ]);

        $article = Article::create($validated);

        return response()->json($article, Response::HTTP_CREATED);
    }

    /**
     * Display the specified article.
     */
    public function show($id)
    {
        $article = Article::findOrFail($id);

        return response()->json($article, Response::HTTP_OK);
    }

    /**
     * Update the specified article in storage.
     */
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $validated = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'content'     => 'sometimes|required|string',
            'source_url'  => 'sometimes|required|url',
            'type'        => 'sometimes|required|in:original,updated',
            'references'  => 'nullable|array',
        ]);

        $article->update($validated);

        return response()->json($article, Response::HTTP_OK);
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy($id)
    {
        Article::findOrFail($id)->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
