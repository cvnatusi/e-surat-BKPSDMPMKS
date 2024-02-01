<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSudahDisposisi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tr_surat_masuk', function (Blueprint $table) {
          $table->string('status_disposisi')->nullable()->comment('Disposisi Kaban, Terima Sekretaris, Disposisi Sekretaris, Selesai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tr_surat_masuk', function (Blueprint $table) {
          $table->dropColumn('status_disposisi');
        });
    }
}
