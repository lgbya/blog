<?php

namespace App\Models;

class Category extends BaseModel
{

    protected $table = 'category';

    public static function boot()
    {
        parent::boot();
        static::deleted(function ($model)
        {
            if(Article::count()>0){
                throw new \Exception('请删除所有关于此分类的文章！！！');
            }
        });
    }

    public static function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name'=>'分类名称',
            'sort'=>'排序',
            'status'=> '启用状态',
            'created_at'=> '创建时间',
            'updated_at'=> '修改时间',
        ];
    }

}
