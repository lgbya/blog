<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    const TABLE_NAME = 'category';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name', 10)->nullable(false)->default('')->comment('分类标题');
            $table->unsignedTinyInteger('sort')->unsigned()->nullable(false)->default(0)->comment('排序');
            $table->unsignedTinyInteger('status')->unsigned()->nullable(false)->default(0)->comment('是否显示前台:1-是,0-否');
            $table->timestamps();
            $table->engine = 'innodb';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
}
