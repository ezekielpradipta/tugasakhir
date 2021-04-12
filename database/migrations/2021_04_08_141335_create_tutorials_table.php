<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutorials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tak_id');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->string('tutorial_bukti')->nullable();
            $table->date('tutorial_tanggalawal');
            $table->string('tutorial_tahunajaran');
            $table->string('tutorial_penyelenggara');
            $table->date('tutorial_tanggalakhir');
            $table->string('tutorial_namaindo');
            $table->string('tutorial_namainggris');
            $table->string('tutorial_deskripsi');
            $table->enum('tutorial_status',['1','0'])->default('0');
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
        Schema::dropIfExists('tutorials');
    }
}
