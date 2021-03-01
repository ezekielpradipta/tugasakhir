<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Mahasiswa;
class CreateMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('dosen_id');
            $table->unsignedBigInteger('prodi_id');
            $table->unsignedBigInteger('angkatan_id');
            $table->foreign('dosen_id')->references('id')->on('dosens')->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('prodi_id')->references('id')->on('prodis')->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('angkatan_id')->references('id')->on('angkatans')->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('mahasiswa_nim');
            $table->string('mahasiswa_nama');
            $table->string('mahasiswa_image')->default(Mahasiswa::USER_PHOTO_DEFAULT);
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
        Schema::dropIfExists('mahasiswas');
    }
}
