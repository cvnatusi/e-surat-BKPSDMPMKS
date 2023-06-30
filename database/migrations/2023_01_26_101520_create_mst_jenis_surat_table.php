<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstJenisSuratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_jenis_surat', function (Blueprint $table) {
          $table->bigIncrements('id_mst_jenis_surat');
          $table->string('kode_jenis_surat');
          $table->string('nama_jenis_surat');
          $table->string('klasifikasi_jenis_surat')->comment('Masuk / Keluar');
          $table->timestamps();
          $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_jenis_surat');
    }
}
