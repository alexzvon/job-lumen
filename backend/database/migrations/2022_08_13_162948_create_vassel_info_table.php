<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vassel_info', function (Blueprint $table) {
            $table->bigIncrements('uid');
            $table->bigInteger('uid_sdn_entry');
            $table->string('call_sign')->nullable();
            $table->string('vessel_type')->nullable();
            $table->string('vessel_flag')->nullable();
            $table->string('vessel_owner')->nullable();
            $table->string('gross_registered_tonnage')->nullable();

            $table->foreign('uid_sdn_entry')->references('uid')->on('sdn_entry');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vassel_info');
    }
};
