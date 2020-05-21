<?php

namespace App\Models;

class Label extends BaseModel
{
    protected $table = 'label';

    public static function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name'=>'标签名称',
            'sort'=>'排序',
            'status'=> '启用状态',
            'created_at'=> '创建时间',
            'updated_at'=> '修改时间',
        ];
    }

    public static function boot()
    {
        parent::boot();
        static::deleted(function ($model)
        {
            if(ArticleLabelOtm::where('label_id', $model->id)->delete() === false){
                throw new \Exception('文章标签关联删除失败！！！');
            }
        });
    }
}
