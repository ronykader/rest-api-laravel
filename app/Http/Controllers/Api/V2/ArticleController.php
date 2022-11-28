<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleResourceCollection;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PHPUnit\Util\Json;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): object
    {
        $articles =  new ArticleResourceCollection(Article::all());
        return response()->json(['status' => true, 'data' => $articles, 'message' => 'Success']);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request): JsonResponse
    {
        try {
            $article = new Article;
            $article->title = $request->title;
            $article->article = $request->article;
            $article->save();
            return response()->json(['status' => true, 'data' => '', 'message' => 'You have created an article successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'data' => '', 'message' => $th->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article): JsonResponse
    {

        $details = new ArticleResource($article);

        return response()->json(['status' => true, 'data' => $details, 'message' => 'success']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article): JsonResponse
    {
        $article->update($request->validated());
        return response()->json(['status' => true, 'data' => $article, 'message' => 'You have successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article): JsonResponse
    {
        $article->delete();
        return response()->json(['status' => true, 'data' => $article, 'message' => 'You have deleted successfully']);
    }
}