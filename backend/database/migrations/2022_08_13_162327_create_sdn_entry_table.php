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
        Schema::create('sdn_entry', function (Blueprint $table) {
            $table->bigInteger('uid');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('sdn_type')->nullable();
            $table->string('title')->nullable();
            $table->text('remarks')->nullable();

            $table->primary('uid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sdn_entry');
    }
};
