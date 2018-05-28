<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomerIdClients extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('customer_id',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('phone');
        });
    }
}
