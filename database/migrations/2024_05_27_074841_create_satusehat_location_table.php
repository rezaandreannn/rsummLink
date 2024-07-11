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
        Schema::connection(config('satusehatintegration.database_connection_master'))->create(config('satusehatintegration.location_table_name'), function (Blueprint $table) {
            $table->id();
            $table->string('location_id');
            $table->string('name');
            $table->string('status');
            $table->string('physical_type')->nullable();
            $table->string('organization_id')->nullable();
            $table->text('description')->nullable();
            $table->string('part_of')->nullable();
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
        Schema::connection(config('satusehatintegration.database_connection_master'))->dropIfExists(config('satusehatintegration.location_table_name'));
    }
};
