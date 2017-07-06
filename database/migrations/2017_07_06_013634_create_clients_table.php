<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
     /**
      * Run the migrations.
      *
      * @return void
      */
    public function up()
    {
//        Schema::dropIfExists('clients');

        Schema::create('ddds', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->char('contractno', 10)->default('')->comment('合同编号');
            $table->smallInteger('is_continue')->unsigned()->default(1)->comment('1-首次投资；2-非首次；3-续投');
            $table->char('client', 10)->default('')->comment('出借人姓名');
            $table->char('client', 18)->default('')->comment('出借人身份证ID');
            $table->char('gender', 1)->default('M')->comment('M-男，F-女');
            $table->smallInteger('bond_type')->unsigned()->default(1)->comment('债券接受方式（1-纸质；2-电子邮件；3-两者皆收；4-无需填写）');
            $table->string('name');
            $table->string('airline');
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
        Schema::drop('clients');
    }
}
