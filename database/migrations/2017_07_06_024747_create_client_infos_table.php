<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('client_infos');

        Schema::create('client_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fuyou_account', 30)->default('')->comment('富有账号');
            $table->tinyInteger('pay_type')->unsigned()->default(1)->comment('支付方式（1-银盛POS机；2-富友金帐户充值；3-委托划扣；4-无需划扣；5-无需填写）');
            $table->time('deduct_time')->comment('划扣时间');
            $table->char('posno', 10)->default('')->comment('POS机终端号');
            $table->decimal('fee', 4, 4)->default(0)->comment('手续费');
            $table->string('import_bank', 64)->default('')->comment('汇入银行');
            $table->string('import_account', 32)->default('')->comment('汇入账户');
            $table->string('import_name', 16)->default('')->comment('汇入姓名');
            $table->string('export_bank', 64)->default('')->comment('回款银行');
            $table->string('export_account', 32)->default('')->comment('回款账户');
            $table->string('export_name', 16)->default('')->comment('回款姓名');
            $table->tinyInteger('area_id')->unsigned()->comment('区域ID');
            $table->string('area_name', 16)->default('')->comment('区域名');
            $table->tinyInteger('city_id')->unsigned()->comment('城市ID');
            $table->string('city_name', 16)->default('')->comment('城市名');
            $table->string('section', 32)->default('')->comment('所属部门');
            $table->string('director', 16)->default('')->comment('大区总监');
            $table->string('area_manager', 16)->default('')->comment('区域经理');
            $table->string('city_manager', 16)->default('')->comment('城市经理');
            $table->string('store_manager', 16)->default('')->comment('门店经理');
            $table->string('team_manager', 16)->default('')->comment('团队经理');
            $table->string('account_manager', 16)->default('')->comment('客户经理');
            $table->char('account_manager_cardid', 18)->default('')->comment('客户经理身份证ID');
            $table->tinyInteger('status')->unsigned()->default(1)->comment('状态（1-正常）');
            $table->softDeletes();
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
        Schema::table('client_infos', function (Blueprint $table) {
            //
        });
    }
}
