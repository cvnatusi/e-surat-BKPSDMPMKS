<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrSuratMasukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_surat_masuk', function (Blueprint $table) {
          $table->bigIncrements('id_surat_masuk');
          $table->string('no_agenda');
          $table->string('nomor_surat_masuk');
          $table->integer('pengirim_surat_id');
          $table->integer('sifat_surat_id');
          $table->integer('jenis_surat_id');
          $table->date('tanggal_surat');
          $table->date('tanggal_terima_surat');
          $table->string('perihal_surat');
          $table->text('isi_ringkas_surat');
          $table->string('catatan_tambahan')->nullable();
          $table->string('file_scan')->nullable();
          $table->string('sampai_bkpsdm')->nullable()->default('N');
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
        Schema::dropIfExists('tr_surat_masuk');
    }
}
