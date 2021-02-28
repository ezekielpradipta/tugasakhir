<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKegiatantaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kegiatantaks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pilartak_id');
            $table->string('kegiatantak_nama');
            $table->foreign('pilartak_id')->references('id')->on('pilartaks')->onDelete('cascade')->onUpdate('cascade');
            
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
        Schema::dropIfExists('kegiatantaks');
    }
}
