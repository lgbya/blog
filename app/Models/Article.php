<?php

namespace App\Models;

use Encore\Admin\Form\Field\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Article extends BaseModel
{
    const IMAGE_PATH = '/article/image';

    protected $table = 'article';

    public static function boot()
    {
        parent::boot();
        static::deleted(function ($model)
        {
            Storage::disk('admin')->delete( $model->image);

            if(ArticleLabelOtm::where('article_id', $model->id)->delete() === false){
                throw new \Exception('文章标签关联删除失败！！！');
            }
        });
    }

    public static function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title'=> '标题',
            'category_id'=>'分类',
            'description'=>'描述',
            'image'=>'图片',
            'content' => '内容',
            'hits' => '点击率',
            'sort'=>'排序',
            'status'=> '启用状态',
            'created_at'=> '创建时间',
            'updated_at'=> '修改时间',
        ];
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function articleLabelOtm()
    {
        return $this->hasMany(ArticleLabelOtm::class, 'article_id', 'id');
    }

    public function prepareData($lsData)
    {
        if(isset($lsData['image'])){
            $oImage = new Image('image');
            $oImage->uniqueName()->move(self::IMAGE_PATH);
            $this->image  = $oImage->prepare($lsData['image']);
        }

        $this->category_id = $lsData['category_id'];
        $this->title = $lsData['title'];
        $this->description = isset($lsData['description'])?$lsData['description']:'';
        $this->sort = $lsData['sort'];
        $this->status = $lsData['status'];
        $this->content = isset($lsData['content'])?$lsData['content']:'';
    }

    public function saveData($lsData = [])
    {
        DB::beginTransaction();

        $this->prepareData($lsData);

        $mArticleLabelOtm = new ArticleLabelOtm();

        if($this->exists){
            if($mArticleLabelOtm::where('article_id',  $this->id)->delete() === false){
                DB::rollBack();
                return false;
            }
        }

        if(!$this->save()){
            DB::rollBack();
            return false;
        }

        if(isset($lsData['labels'])){
            $lsLabel = [];
            foreach ($lsData['labels'] as $k => $v){
                if(isset($v)){
                    $lsLabel[] = ['article_id' => $this->id, 'label_id' => $v];
                }
            }

            if(!DB::table($mArticleLabelOtm->getTable())->insert($lsLabel)){
                DB::rollBack();
                return false;
            }
        }

        DB::commit();
        return true;
    }


}
