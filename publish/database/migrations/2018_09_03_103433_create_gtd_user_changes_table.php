<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGtdUserChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gtd_user_changes', function (Blueprint $table) {
            $table->integer('user_id');
            $table->string('email',255)->nullable();
            $table->string('phone',255)->nullable();
            $table->string('token',255);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gtd_user_changes');
    }
}
