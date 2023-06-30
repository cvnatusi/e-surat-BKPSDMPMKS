<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrFileSuratPerjalananDinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_file_surat_perjalanan_dinas', function (Blueprint $table) {
          $table->bigIncrements('id_file_perjalanan_dinas');
          $table->integer('surat_tugas_id');
          $table->integer('asn_id');
          $table->string('file_surat_tugas')->nullable();
          $table->string('file_surat_sppd')->nullable();
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
        Schema::dropIfExists('tr_file_surat_perjalanan_dinas');
    }
}
