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
        Schema::create('satusehat_encounter_mapping', function (Blueprint $table) {
            $table->id();
            $table->string('dokter_id');
            $table->string('organization_id');
            $table->string('location_id');
            $table->enum('cara_masuk', ['1', '2', '3'])->nullable(); //1. rajal, 2. ranap, 3. igd
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('satusehat_encounter_mapping');
    }
};
