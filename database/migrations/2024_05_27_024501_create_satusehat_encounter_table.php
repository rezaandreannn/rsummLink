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
            $table->string('class_code');
            $table->string('patient_ihs');
            $table->string('patient_name');
            $table->string('practitioner_ihs');
            $table->string('practitioner_name');
            $table->string('location_id');
            $table->string('service_provider')->nullable();
            $table->string('status')->nullable();
            $table->string('status_history')->nullable();
            $table->timestamp('periode_start')->nullable();
            $table->timestamp('periode_end')->nullable();
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
