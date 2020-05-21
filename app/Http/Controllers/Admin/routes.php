<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->post('/upload-file', 'UploadsController@index');
    $router->resource('categories', 'CategoryController');
    $router->resource('labels', 'LabelController');
    $router->resource('articles', 'ArticleController');

});
