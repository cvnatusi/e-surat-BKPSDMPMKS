<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToTrSuratPerjalananDinas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tr_surat_perjalanan_dinas', function (Blueprint $table) {
            $table->string('keterangan', 255)->nullable();
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
            $table->dropColumn('keterangan', 255)->nullable();
        });
    }
}
