<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstansisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instansis', function (Blueprint $table) {
            $table->string('instansi_id',50)->primary();
            $table->string('user_id',50);
            $table->string('nama',150);
            $table->string('latitude',50);
            $table->string('longitude',50);
            $table->string('waktu_mulai_operasi',50);
            $table->string('waktu_selesai_operasi',50);
            $table->text('deskripsi')->nullable();
            $table->string('gambar',150)->nullable();
            $table->string('status',50)->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instansis');
    }
}
