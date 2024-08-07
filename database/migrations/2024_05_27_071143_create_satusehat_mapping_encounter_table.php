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
        Schema::connection(config('satusehatintegration.database_connection_master'))->create(config('satusehatintegration.mapping_encounter_table_name'), function (Blueprint $table) {
            $table->id();
            $table->string('kode_dokter');
            $table->string('practitioner_ihs');
            $table->string('practitioner_display');
            $table->string('location_id');
            $table->string('location_display');
            $table->string('organization_id');
            $table->string('type')->nullable();
            $table->boolean('status')->default(1)->nullable();
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
        Schema::connection(config('satusehatintegration.database_connection_master'))->dropIfExists(config('satusehatintegration.mapping_encounter_table_name'));
    }
};
