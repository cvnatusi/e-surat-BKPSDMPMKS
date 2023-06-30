<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrSuratBastTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_surat_bast', function (Blueprint $table) {
          $table->bigIncrements('id_surat_bast');
          $table->string('no_agenda');
          $table->string('nomor_surat_bast')->nullable();
          $table->string('penyedia_jasa');
          $table->string('jenis_pekerjaan');
          $table->text('kegiatan');
          $table->date('tanggal_surat');
          $table->string('jumlah');
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
        Schema::dropIfExists('tr_surat_bast');
    }
}
