<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInputtaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inputtaks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tak_id');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->string('inputtak_bukti');
            $table->date('inputtak_tanggalawal');
            $table->string('inputtak_tahunajaran');
            $table->string('inputtak_penyelenggara');
            $table->date('inputtak_tanggalakhir');
            $table->string('inputtak_namaindo');
            $table->string('inputtak_namainggris');
            $table->string('inputtak_deskripsi');
            $table->enum('inputtak_status',['1','0'])->default('0');
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswas')->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('tak_id')->references('id')->on('taks')->onDelete('cascade')
            ->onUpdate('cascade');
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
        Schema::dropIfExists('inputtaks');
    }
}
