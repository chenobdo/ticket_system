<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddZipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zips', function (Blueprint $table) {
                $table->increments('id');
                $table->string('zip_name', 64)->comment('账单包名');
                $table->string('path', 255);
                $table->tinyInteger('type')->comment('1-手动；2-自动');
                $table->integer('uid')->comment('操作人');
                $table->text('mark')->comment('备注');
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
        Schema::table('zips', function (Blueprint $table) {
            //
        });
    }
}
