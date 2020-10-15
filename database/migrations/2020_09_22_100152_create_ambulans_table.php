<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmbulansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambulans', function (Blueprint $table) {
            $table->string('ambulan_id',50)->primary();
            $table->string('instansi_id',50);
            $table->string('plat_nomor',20);
            $table->string('nama_sopir',50)->nullable();
            $table->string('nomor_telepon',20)->nullable();
            $table->string('gambar',150)->nullable();
            $table->string('merk',50)->nullable();
            $table->string('status',50)->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('instansi_id')->references('instansi_id')->on('instansis');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ambulans');
    }
}
