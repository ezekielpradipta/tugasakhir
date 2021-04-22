<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTakkumulatifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('takkumulatifs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('angkatan_id');
            $table->unsignedBigInteger('prodi_id');
            $table->integer('poinminimum')->default(0);
            $table->foreign('angkatan_id')->references('id')->on('angkatans')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('prodi_id')->references('id')->on('prodis')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('takkumulatifs');
    }
}
