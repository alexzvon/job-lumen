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
        Schema::create('id_list', function (Blueprint $table) {
            $table->bigInteger('uid');
            $table->bigInteger('uid_sdn_entry');
            $table->string('id_type')->nullable();
            $table->string('id_country')->nullable();
            $table->text('id_number')->nullable();

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
        Schema::dropIfExists('id_list');
    }
};
