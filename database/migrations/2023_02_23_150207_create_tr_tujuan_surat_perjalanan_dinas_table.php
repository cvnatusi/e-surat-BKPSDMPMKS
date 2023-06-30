<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrTujuanSuratPerjalananDinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_tujuan_surat_perjalanan_dinas', function (Blueprint $table) {
          $table->bigIncrements('id_tujuan_perjalanan_dinas');
          $table->integer('surat_tugas_id');
          $table->date('tanggal_mulai_tugas');
          $table->date('tanggal_akhir_tugas');
          $table->string('tempat_tujuan_bertugas');
          $table->string('provinsi_tujuan_bertugas');
          $table->string('alamat_tujuan_bertugas');
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
        Schema::dropIfExists('tr_tujuan_surat_perjalanan_dinas');
    }
}
