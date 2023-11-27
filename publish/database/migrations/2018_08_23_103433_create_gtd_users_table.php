<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGtdUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gtd_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id')->default(0);//归属于某个team
            $table->string('username',64)->unique()->comment('用户名');
            $table->string('password',255);
            $table->string('salt',32);
            $table->string('nickname',255)->nullable()->comment('昵称');
            $table->string('realname',255)->nullable()->comment('姓名');
            $table->string('email')->unique()->comment('邮箱');
            $table->string('phone')->unique()->nullable();
            $table->enum('gender', ['male', 'female', 'secret', 'unkown']);
            $table->string('reset_token',255)->nullable();
            $table->string('remember_token',255)->nullable();

            $table->integer('credit')->default(0);//积分
            $table->integer('grade_id')->default(0);//类型
            $table->integer('type_id')->default(0);//类型

            $table->string('link',255)->nullable();
            $table->string('link_wechat',255)->nullable();
            $table->string('link_qq',255)->nullable();
            $table->string('link_twitter',255)->nullable();
            $table->string('link_github',255)->nullable();
            $table->string('link_blog',255)->nullable();

            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('address')->nullable();

            $table->tinyInteger('badge_star')->default(0);
            $table->tinyInteger('badge_certificate')->default(0);
            
            $table->string('source',255)->nullable();//注册来源
            $table->string('invite_code',255)->nullable();//邀请码
            $table->string('registration_reason',255)->nullable();//注册原因
            $table->tinyInteger('status')->default(1); //0未激活，1激活，2禁用
            $table->timestamps();
            $table->softDeletes();
            $table->index('username');
            $table->index('email');
            $table->index('phone');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gtd_users');
    }
}
