<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleResourceCollection;
use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Http\JsonResponse as JsonResponseAlias;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PHPUnit\Util\Json;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): object
    {
        $articles =  new ArticleResourceCollection(Article::all());
        return response()->json(['status' => true, 'data' => $articles, 'message' => 'Success']);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param ArticleRequest $request
     * @return JsonResponseAlias
     */
    public function store(ArticleRequest $request): JsonResponseAlias
    {
        try {
            $article = (new ArticleService())->createArticle($request);
            return response()->json(['status' => true, 'data' => $article, 'message' => 'You have successfully created an article'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'data' => '', 'message' => $th->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @return JsonResponseAlias
     */
    public function show(Article $article): JsonResponseAlias
    {
        try {
            $details = new ArticleResource($article);
            return response()->json(['status' => true, 'data' => $details, 'message' => 'success']);
        } catch (\Throwable $th) {
             return response()->json(['status' => false, 'data' => '', 'message' => $th->getMessage()], 422);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param ArticleRequest $request
     * @param Article $article
     * @return JsonResponseAlias
     */
    public function update(ArticleRequest $request, Article $article): JsonResponseAlias
    {
        try {
            $article->update($request->validated());
            return response()->json(['status' => true, 'data' => $article, 'message' => 'You have successfully updated']);
        }catch (\Throwable $th) {
            return response()->json(['status' => false, 'data' => '', 'message' => $th->getMessage()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $article
     * @return JsonResponseAlias
     */
    public function destroy(Article $article): JsonResponseAlias
    {
        try {
            $article->delete();
            return response()->json(['status' => true, 'data' => $article, 'message' => 'You have deleted successfully']);
        }catch (\Throwable $th) {
            return response()->json(['status' => false, 'data' => '', 'message' => $th->getMessage()], 422);
        }
    }

}
