<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->nullable($value=false);
            $table->string('perihal')->nullable($value=false);
            $table->text('deskripsi')->nullable($value=true);
            $table->text('peserta')->nullable($value=false);
            $table->date('tgl_mulai')->nullable($value=false);
            $table->date('tgl_selesai')->nullable($value=false);
            $table->time('jam_mulai')->nullable($value=false);
            $table->time('jam_selesai')->nullable($value=true);
            $table->unsignedBigInteger('id_lokasi');
            $table->foreign('id_lokasi')->references('id_lokasi')->on('lokasi')
                                    ->onUpdate('cascade')
                                    ->onDelete('cascade');
            $table->string('file')->nullable($value=true); //harus diisi
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
        Schema::dropIfExists('agenda');
    }
}
