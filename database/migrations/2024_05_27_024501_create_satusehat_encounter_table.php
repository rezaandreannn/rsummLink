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
        Schema::connection(config('satusehatintegration.database_connection_satusehat'))->create(config('satusehatintegration.encounter_table_name'), function (Blueprint $table) {
            $table->id();
            $table->string('encounter_id');
            $table->string('kode_register');
            $table->string('patient_id');
            $table->string('practitioner_id');
            $table->string('location_id');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::connection(config('satusehatintegration.database_connection_satusehat'))->dropIfExists(config('satusehatintegration.encounter_table_name'));
    }
};
