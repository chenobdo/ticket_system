<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertClientInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_infos', function (Blueprint $table) {
            $table->decimal('fee', 8, 2)->default(0)->comment('手续费')->change();
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
