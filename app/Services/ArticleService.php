<?php

namespace App\Services;

use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleService
{
    /**
     * @param $request
     * @return ArticleResource
     */
    public function createArticle($request): ArticleResource
    {
        $article = new Article;
        $article->title = $request->title;
        $article->slug = $request->slug;
        $article->article = $request->article;
        $article->save();
        return new ArticleResource($article);
    }
}
