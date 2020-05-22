<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleSearch;
use App\Models\Category;
use App\Models\Label;

class IndexController extends Controller
{
    protected $categories;
    protected $labels;

    public function __construct()
    {
        $lsLabel = Label::where('status', Article::STATUS_ON)
            ->get()->pluck('name','id')->toArray();

        $lsCategory = Category::orderBy('sort', 'desc')
            ->orderBy('created_at', 'desc')
            ->where('status', Article::STATUS_ON)
            ->get();

        view()->share([
            'lsLabel' => $lsLabel,
            'lsCategory'=> $lsCategory,
        ]);
    }

    public function index()
    {
        $lsArticle = ArticleSearch::search(request());
        return view('frontend.index.index', [
            'lsArticle' => $lsArticle,
        ]);

    }

    public function details($id)
    {

        $lArticle = Article::findOrFail($id)->with(['category', 'articleLabelOtm'])
            ->where('status', Article::STATUS_ON)
            ->first();
        $lArticle->increment('hits');
        return view('frontend.index.details', [
            'info' => $lArticle,
        ]);
    }

}
