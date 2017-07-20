<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('bills');

        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->comment('客户ID');
            $table->string('year_month', 6)->comment('年月');
            $table->date('date')->comment('年月');
            $table->decimal('interest', 10, 2)->default(0)->comment('预期报告日收益');
            $table->decimal('net_interest', 10, 2)->default(0)->comment('预期报告日净收益');
            $table->decimal('total_assets', 10, 2)->default(0)->comment('资产总额');
            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
