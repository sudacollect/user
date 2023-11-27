<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGtdUserGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gtd_user_grades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id')->default(0);//类型
            $table->string('grade_name',255);
            $table->tinyInteger('status')->default(1); //0未激活，1激活，2禁用
            $table->timestamps();
            $table->index('type_id');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gtd_user_grades');
    }
}
