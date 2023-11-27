<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGtdCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gtd_certificates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_id',255)->comment('订单编号');
            $table->enum('certi_type', ['personal', 'team', 'company', 'organization', 'edu']);
            $table->string('certi_name',255)->comment('认证信息');
            $table->string('certi_no',255)->comment('认证编号');
            $table->integer('user_id');
            $table->integer('team_id')->default(0);
            $table->integer('operate_id')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('serial',255)->nullable();
            $table->text('certi_product')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->index('order_id');
            $table->index('certi_no');
            $table->index('user_id');
        });
        
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gtd_certificates');
    }
}
