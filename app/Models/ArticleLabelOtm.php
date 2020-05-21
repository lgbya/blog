<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleLabelOtm extends Model
{
    protected $table = 'article_label_otm';

    public $timestamps = false;

    public function labels()
    {
        return $this->hasOne(Label::class, 'id', 'label_id');
    }

    public static function labelIdToNameList($articleId)
    {
        $lLabelIdToName = [];
        $qlLabel = self::where('article_id', $articleId)->with('labels')->get();
        foreach($qlLabel as $k => $v){
            $lLabelIdToName[$v->labels->id] = $v->labels->name;
        }
        return $lLabelIdToName;
    }

}
