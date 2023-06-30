<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrTandatanganElektronikTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_tandatangan_elektronik', function (Blueprint $table) {
            $table->id();
            $table->string('pengguna');
            $table->string('kode_surat');
            $table->string('nama_badan');
            $table->string('nama_kepala_badan');
            $table->string('jabatan');
            $table->string('nip');
            $table->string('gambar');
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
        Schema::dropIfExists('tr_tandatangan_elektronik');
    }
}
