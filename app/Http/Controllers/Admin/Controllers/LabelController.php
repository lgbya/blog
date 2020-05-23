<?php

namespace App\Http\Controllers\Admin\Controllers;

use App\Models\Label;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class LabelController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '标签';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $lStatusEnum = Label::statusEnum();
        $lAttributeLabel = Label::attributeLabels();

        $grid = new Grid(new Label());
        $grid->column('id', $lAttributeLabel['id'])->sortable();
        $grid->column('name', $lAttributeLabel['name'])->filter('like');
        $grid->column('sort', $lAttributeLabel['sort'])->sortable();
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
        $lAttributeLabel = Label::attributeLabels();

        $show = new Show(Label::findOrFail($id));
        $show->field('id', $lAttributeLabel['id']);
        $show->field('name', $lAttributeLabel['name']);
        $show->field('sort',  $lAttributeLabel['sort']);
        $show->field('status',  $lAttributeLabel['status'])->using(Label::statusEnum());
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
        $lAttributeLabel = Label::attributeLabels();

        $form = new Form(new Label());
        $form->text('name', $lAttributeLabel['name'])->required()->rules('required');
        $form->number('sort', $lAttributeLabel['sort'])->required()->value(0)->rules('required|integer');
        $form->select('status', $lAttributeLabel['status'])->options(Label::statusEnum())->default(Label::STATUS_ON);
        return $form;
    }
}
