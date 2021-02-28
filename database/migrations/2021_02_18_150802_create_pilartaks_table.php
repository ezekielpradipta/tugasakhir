<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePilartaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pilartaks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategoritak_id');
            $table->string('pilartak_nama');
            $table->foreign('kategoritak_id')->references('id')->on('kategoritaks')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('pilartaks');
    }
}
