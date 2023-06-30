<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrSuratPerjalananDinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_surat_perjalanan_dinas', function (Blueprint $table) {
          $table->bigIncrements('id_surat_perjalanan_dinas');
          $table->string('no_agenda');
          $table->string('nomor_surat_perjalanan_dinas')->nullable();
          $table->integer('yang_bertanda_tangan_asn_id');
          $table->integer('asn_id');
          $table->date('tanggal_surat');
          $table->date('tanggal_mulai');
          $table->date('tanggal_akhir');
          $table->string('perihal_surat');
          $table->text('isi_ringkas_surat');
          $table->string('alat_angkut')->comment('Kendaraan Umum, Kendaraan Dinas');
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
        Schema::dropIfExists('tr_surat_perjalanan_dinas');
    }
}
