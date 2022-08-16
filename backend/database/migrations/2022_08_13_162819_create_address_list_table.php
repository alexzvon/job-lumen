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
        Schema::create('address_list', function (Blueprint $table) {
            $table->bigInteger('uid');
            $table->bigInteger('uid_sdn_entry');
            $table->string('city')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('address3')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();

            $table->primary('uid');
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
        Schema::dropIfExists('address_list');
    }
};
