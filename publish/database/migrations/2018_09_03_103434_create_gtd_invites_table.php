<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGtdInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gtd_invites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('invite_code',64)->nullable();
            $table->integer('invite_user_id')->default(0);
            $table->timestamps();
            $table->index(['invite_user_id', 'invite_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gtd_invites');
    }
}
