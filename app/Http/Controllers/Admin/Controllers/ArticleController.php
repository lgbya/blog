<?php

namespace App\Http\Controllers\Admin\Controllers;

use App\Models\Article;
use App\Models\ArticleLabelOtm;
use App\Models\Category;
use App\Models\Label;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Storage;

class ArticleController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '文章';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        $grid = new Grid(new Article());
        $lStatusEnum = Article::statusEnum();
        $lAttributeLabel = Article::attributeLabels();

        $lCategory = Category::all()->pluck('name','id')->toArray();

        $grid->column('id', $lAttributeLabel['id'])->sortable();
        $grid->column('title', $lAttributeLabel['title'])->filter('like');
        $grid->column('category_id', $lAttributeLabel['category_id'])->using($lCategory)->filter($lCategory)->sortable();
        $grid->column('hits', $lAttributeLabel['hits']);
        $grid->column('sort', $lAttributeLabel['sort']);
        $grid->column('status', $lAttributeLabel['status'])->using($lStatusEnum)->filter($lStatusEnum)->sortable();
        $grid->column('description', $lAttributeLabel['description']);
        $grid->column('image', $lAttributeLabel['image'])->image();
        $grid->column('created_at', $lAttributeLabel['created_at'])->filter('range', 'datetime')->sortable();
        $grid->column('updated_at', $lAttributeLabel['updated_at'])->filter('range', 'datetime')->sortable();
        $grid->filter(function ($filter) use ($lAttributeLabel, $lStatusEnum, $lCategory){
            $filter->disableIdFilter();
            $filter->like('title', $lAttributeLabel['title']);
            $filter->equal('category_id', $lAttributeLabel['category_id'])->multipleSelect($lCategory);
            $filter->equal('status', $lAttributeLabel['status'])->multipleSelect($lStatusEnum);
            $filter->between('created_at', $lAttributeLabel['created_at'])->datetime();
            $filter->between('updated_at', $lAttributeLabel['updated_at'])->datetime();
        });
        $grid->model()->latest();
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {

        $lSelectLabel = ArticleLabelOtm::labelIdToNameList($id);
        $lAttributeLabel = Article::attributeLabels();
        $lCategory = Category::all()->pluck('name','id')->toArray();

        $show = new Show(Article::findOrFail($id));
        $show->field('category_id', $lAttributeLabel['category_id'])->using($lCategory);
        $show->field('labels', '标签栏')->as(function () use ($lSelectLabel){
            return join($lSelectLabel, '    |  ');
        });
        $show->field('title', $lAttributeLabel['title']);
        $show->field('description', $lAttributeLabel['description']);
        $show->field('image', $lAttributeLabel['image'])->image();
        $show->field('hits', $lAttributeLabel['hits']);
        $show->field('sort',  $lAttributeLabel['sort']);
        $show->field('status',  $lAttributeLabel['status'])->using(Article::statusEnum());
        $show->field('created_at', $lAttributeLabel['created_at']);
        $show->field('updated_at',  $lAttributeLabel['updated_at']);
        $show->field('content', $lAttributeLabel['content'])->unescape()->editormd();

        return $show;
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        $lSelectLabel = ArticleLabelOtm::labelIdToNameList($id);
        return $content
            ->title($this->title())
            ->description($this->description['edit'] ?? trans('admin.edit'))
            ->body($this->form($lSelectLabel)->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description['create'] ?? trans('admin.create'))
            ->body($this->form());
    }


    public function store()
    {
        $mArticle = new Article();
        $mArticle->saveData(request()->all());
    }


    public function update($id)
    {
        $qArticle = Article::findOrFail($id);
        $qArticle->saveData(request()->all());
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($lSelectLabel = [])
    {

        $form = new Form(new Article());
        $lAttributeLabel = Article::attributeLabels();
        $lCategory = Category::all()->pluck('name','id')->toArray();
        $lLabel = Label::all()->pluck('name','id')->toArray();

        $form->text('title', $lAttributeLabel['title'])->required()->rules('required');
        $form->select('category_id', $lAttributeLabel['category_id'])->options($lCategory)->rules('required');
        $form->multipleSelect("labels",'标签')->options($lLabel)->default(array_keys($lSelectLabel));
        $form->text('description', $lAttributeLabel['description']);
        $form->number('sort', $lAttributeLabel['sort'])->required()->value(0)->rules('required|integer');
        $form->select('status', $lAttributeLabel['status'])->options(Article::statusEnum());
        $form->image('image', $lAttributeLabel['image']);
        $form->editormd('content', $lAttributeLabel['content']);
        return $form;
    }
}
