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
        Schema::dropIfExists('clients');

        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->char('contractno', 10)->default('')->comment('合同编号');
            $table->tinyInteger('is_continue')->unsigned()->default(1)->comment('1-首次投资；2-非首次；3-续投；4-无需填写');
            $table->char('client', 10)->default('')->comment('出借人姓名');
            $table->string('cardid', 18)->default('')->comment('出借人身份证ID');
            $table->char('gender', 1)->default('M')->comment('M-男，F-女');
            $table->tinyInteger('bond_type')->unsigned()->default(1)->comment('债券接受方式（1-纸质；2-电子邮件；3-两者皆收；4-无需填写）');
            $table->string('address', 255)->default('')->comment('地址');
            $table->string('postcode', 6)->default('')->comment('邮编');
            $table->float('FTC')->default(0)->comment('折标系数');
            $table->decimal('FTA', 8, 4)->default(0)->comment('折标金额');
            $table->date('receipt_date')->comment('回执日期');
            $table->tinyInteger('is_confirm')->unsigned()->default(1)->comment('债权及确认书（1-空）');
            $table->decimal('loan_amount', 8, 4)->default(0)->comment('出借金额');
            $table->string('product_name', 16)->default('')->comment('产品名称');
            $table->tinyInteger('nper')->unsigned()->default(1)->comment('期数');
            $table->float('annualized_return')->default(0)->comment('年华收益率');
            $table->decimal('gross_interest', 8, 4)->default(0)->comment('利息总额');
            $table->decimal('interest_monthly', 8, 4)->default(0)->comment('月付利息');
            $table->date('deduct_date')->comment('划扣日期');
            $table->date('loan_date')->comment('初始出借日期');
            $table->date('due_date')->comment('到期日');
            $table->integer('billing_days')->unsigned()->default(0)->comment('账单日');
            $table->integer('expire_days')->unsigned()->default(0)->comment('到期天数');
            $table->tinyInteger('status')->unsigned()->default(1)->comment('状态（1-正常）');
            $table->integer('client_info_id')->unsigned()->comment('客户信息ID');
            $table->softDeletes();
            $table->timestamps();

            $table->engine = 'InnoDB';

            $table->unique('contractno');

            $table->foreign('client_info_id')->references('id')->on('client_infos');
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
