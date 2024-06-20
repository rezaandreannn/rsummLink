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
        Schema::create('satusehat_pasien', function (Blueprint $table) {
            $table->id();
            $table->string('no_mr');
            $table->string('nik')->nullable();
            $table->string('id_pasien')->nullable();
            $table->string('nama_pasien')->nullable();
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
        Schema::dropIfExists('satusehat_pasien');
    }
};
