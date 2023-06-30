<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrSuratKeluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_surat_keluar', function (Blueprint $table) {
          $table->bigIncrements('id_surat_keluar');
          $table->string('no_agenda');
          $table->enum('surat_elektronik',['Y', 'N'])->default('N');
          $table->enum('surat_manual',['Y', 'N'])->default('N');
          $table->string('nomor_surat_keluar')->nullable();
          $table->string('tujuan_surat_id');
          $table->integer('sifat_surat_id');
          $table->integer('jenis_surat_id');
          $table->date('tanggal_surat');
          $table->string('perihal_surat');
          $table->string('no_surat1')->nullable();
          $table->string('no_surat2')->nullable();
          $table->string('no_surat3')->nullable();
          $table->string('no_surat4')->nullable();
          $table->text('isi_ringkas_surat');
          $table->string('file_scan')->nullable();
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
        Schema::dropIfExists('tr_surat_keluar');
    }
}
