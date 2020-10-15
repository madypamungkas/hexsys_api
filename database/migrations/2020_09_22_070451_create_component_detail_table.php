<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponentDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('component_detail', function (Blueprint $table) {
            $table->bigInteger('com_detail_id')->primary();
            $table->bigInteger('data_cd');
            $table->string('com_cd',50);
            $table->string('code_group',50);
            $table->string('keterangan',255)->nullable();
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
        Schema::dropIfExists('component_detail');
    }
}
