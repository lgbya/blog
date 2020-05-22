<?php

namespace App\Models;

use Illuminate\Http\Request;

class ArticleSearch extends Article
{
    public static function search(Request $request)
    {
        $keyword = $request->get('keyword', '');
        $categoryId = $request->get('category_id', 0);
        $labelId = $request->get('label_id', 0);

        $query = self::with(['category', 'articleLabelOtm']);
        if($keyword){
            $lLabelId = Label::where('name', 'like',  '%'. $keyword . '%')->get()->pluck('id')->toArray();
            $lCategoryId = Category::where('name', 'like',  '%'. $keyword . '%')->get()->pluck('id')->toArray();

            $query->orWhere('title', 'like',  '%'. $keyword . '%');
            $query->orWhere('description', 'like',  '%'. $keyword . '%');
            if(count($lCategoryId)){
                $query->where('category_id', 'in', $categoryId);
            }


            if(count($lLabelId)){
                $query->whereHas('articleLabelOtm',function($query) use ($lLabelId){
                    $query->where('label_id','in', $lLabelId);
                });
            }

        }

        if($labelId ){
            $query->whereHas('articleLabelOtm',function($query) use ($labelId){
                $query->where('label_id', $labelId);
            });
        }

        if($categoryId){
            $query->where('category_id', $categoryId);
        }


        return $query
            ->orderBy('sort', 'desc')
            ->orderBy('created_at', 'desc')
            ->where('status', Article::STATUS_ON)
            ->paginate(10)
            ->appends([
                'keyword' => $keyword,
                'category_id' => $categoryId,
                'label_id' => $labelId,
            ]);

    }

}
