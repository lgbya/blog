<?php

namespace App\Http\Controllers\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Label;
use Encore\Admin\Admin;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        config('admin.title');
        return $content
            ->title('Home')
            ->description('欢迎回来...')
            ->row(function (Row $row) {

                $row->column(4, function (Column $column) {
                    $column->append($this->dependencies());
                });

                $row->column(8, function (Column $column) {
                    $column->append(Dashboard::environment());
                });

//                $row->column(4, function (Column $column) {
//                    $column->append(Dashboard::extensions());
//                });
//

            });
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public  function dependencies()
    {
        $articleAllNum = Article::count();
        $articleOnNum = Article::where('status', Article::STATUS_ON)->count();

        $categoryAllNum = Category::count();
        $categoryOnNum = Category::where('status', Article::STATUS_ON)->count();

        $labelAllNum = Label::count();
        $labelOnNum = Label::where('status', Article::STATUS_ON)->count();

        $dependencies = [
            '总文章数'=> $articleAllNum,
            '发布文章数'=> $articleOnNum,
            '总分类数'=> $categoryAllNum,
            '发布分类数'=> $categoryOnNum,
            '总标签数'=> $labelAllNum,
            '发布标签数'=> $labelOnNum,
        ];

//        Admin::script("$('.dependencies').slimscroll({height:'300px',size:'3px'});");
        return view('admin::dashboard.dependencies', compact('dependencies'));
    }
}
