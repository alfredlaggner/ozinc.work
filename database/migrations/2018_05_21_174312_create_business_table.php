<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->increments('id');
            $table->char('name',50)->nullable;
            $table->char('adult_license_name',50)->nullable;
            $table->char('adult_license_number',50)->nullable;
            $table->char('medicinal_license_name',50)->nullable;
            $table->char('medicinal_license_number',50)->nullable;
            $table->char('street',50)->nullable;
            $table->char('city',50)->nullable;
            $table->char('zip',50)->nullable;
            $table->char('phone',50)->nullable;
            $table->char('email',50)->nullable;
            $table->char('contact',50)->nullable;

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
        Schema::dropIfExists('businesses');
    }
}
