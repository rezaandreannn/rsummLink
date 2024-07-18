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
        Schema::table('satusehat_encounter', function (Blueprint $table) {
            $table->string('metode_konsultasi')->nullable()->after('location_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('satusehat_encounter', function (Blueprint $table) {
            $table->dropColumn('metode_konsultasi');
        });
    }
};
