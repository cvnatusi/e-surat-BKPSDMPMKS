<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnVerifikasiKabanToTrSuratTugas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tr_surat_perjalanan_dinas', function (Blueprint $table) {
          $table->string('verifikasi_kaban')->default('N')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tr_surat_perjalanan_dinas', function (Blueprint $table) {
          $table->dropColumn('verifikasi_kaban');
        });
    }
}
