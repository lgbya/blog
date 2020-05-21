<?php

namespace App\Http\Controllers\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '分类';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        $grid = new Grid(new Category());
        $lStatusEnum = Category::statusEnum();
        $lAttributeLabel = Category::attributeLabels();

        $grid->column('id', $lAttributeLabel['id'])->sortable();
        $grid->column('name', $lAttributeLabel['name'])->filter('like');
        $grid->column('status', $lAttributeLabel['status'])->using($lStatusEnum)->filter($lStatusEnum)->sortable();
        $grid->column('created_at', $lAttributeLabel['created_at'])->filter('range', 'datetime')->sortable();
        $grid->column('updated_at', $lAttributeLabel['updated_at'])->filter('range', 'datetime')->sortable();
        $grid->filter(function ($filter) use ($lAttributeLabel, $lStatusEnum){
            $filter->disableIdFilter();
            $filter->like('name', $lAttributeLabel['name']);
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
        $lAttributeLabel = Category::attributeLabels();

        $show = new Show(Category::findOrFail($id));
        $show->field('id', $lAttributeLabel['id']);
        $show->field('name', $lAttributeLabel['name']);
        $show->field('sort',  $lAttributeLabel['sort']);
        $show->field('status',  $lAttributeLabel['status'])->using(Category::statusEnum());
        $show->field('created_at', $lAttributeLabel['created_at']);
        $show->field('updated_at',  $lAttributeLabel['updated_at']);

        return $show;
    }



    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Category());
        $lAttributeLabel = Category::attributeLabels();

        $form->text('name', $lAttributeLabel['name'])->required()->rules('required');
        $form->number('sort', $lAttributeLabel['sort'])->required()->value(0)->rules('required|integer');
        $form->select('status', $lAttributeLabel['status'])->options(Category::statusEnum());
        return $form;
    }
}
