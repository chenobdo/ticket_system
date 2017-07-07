<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->decimal('FTA', 10, 2)->default(0)->comment('折标金额')->change();
            $table->decimal('loan_amount', 10, 2)->default(0)->comment('出借金额')->change();
            $table->decimal('gross_interest', 10, 2)->default(0)->comment('利息总额')->change();
            $table->decimal('interest_monthly', 10, 2)->default(0)->comment('月付利息')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            //
        });
    }
}
