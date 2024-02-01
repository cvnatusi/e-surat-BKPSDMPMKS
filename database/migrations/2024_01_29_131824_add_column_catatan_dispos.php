<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCatatanDispos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tr_surat_disposisi', function (Blueprint $table) {
          $table->text('catatan_disposisi_sekretaris')->nullable();
          $table->integer('pemberi_disposisi2_id')->nullable();
          $table->integer('penerima_disposisi2_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tr_surat_disposisi', function (Blueprint $table) {
          $table->dropColumn('catatan_disposisi_sekretaris');
          $table->dropColumn('pemberi_disposisi2_id');
          $table->dropColumn('penerima_disposisi2_id');
        });
    }
}
