<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrSuratKeputusanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_surat_keputusan', function (Blueprint $table) {
          $table->bigIncrements('id_surat_keputusan');
          $table->string('no_agenda');
          $table->string('nomor_surat_keputusan')->nullable();
          $table->date('tanggal_surat');
          $table->string('perihal');
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
        Schema::dropIfExists('tr_surat_keputusan');
    }
}
