<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTtdToTrSuratKeluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tr_surat_keluar', function (Blueprint $table) {
          $table->boolean('ttd')->default(true);
          $table->boolean('is_verif')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tr_surat_keluar', function (Blueprint $table) {
          $table->dropColumn('ttd');
          $table->dropColumn('is_verif');
        });
    }
}
