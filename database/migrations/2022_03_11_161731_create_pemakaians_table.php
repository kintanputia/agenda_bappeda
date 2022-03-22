<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemakaiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemakaian', function (Blueprint $table) {
            $table->bigIncrements('id_pemakaian');
            $table->unsignedBigInteger('id');
            $table->foreign('id')->references('id')->on('agenda')
                                    ->onUpdate('cascade')
                                    ->onDelete('cascade');
            $table->unsignedBigInteger('id_lokasi');
            $table->foreign('id_lokasi')->references('id_lokasi')->on('lokasi')
                                    ->onUpdate('cascade')
                                    ->onDelete('cascade');
            $table->date('tgl_pemakaian')->nullable(false);
            $table->time('jam_mulai')->nullable($value=false);
            $table->time('jam_selesai')->nullable($value=false);
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
        Schema::dropIfExists('pemakaian');
    }
}
