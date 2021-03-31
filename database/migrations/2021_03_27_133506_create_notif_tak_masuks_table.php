<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifTakMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notif_tak_masuks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inputtak_id');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('dosen_id');
            $table->enum('notif_tak_read',['1','0'])->default('0');
            $table->foreign('inputtak_id')->references('id')->on('inputtaks')->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswas')->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('dosen_id')->references('id')->on('dosens')->onDelete('cascade')
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
        Schema::dropIfExists('notif_tak_masuks');
    }
}
