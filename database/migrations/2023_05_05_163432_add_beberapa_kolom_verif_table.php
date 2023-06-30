<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBeberapaKolomVerifTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tr_file_tte', function (Blueprint $table) {
          $table->string('file_surat_salinan')->nullable();
          $table->boolean('is_verif')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tr_file_tte', function (Blueprint $table) {
          $table->dropColumn('file_surat_salinan');
          $table->enum('is_verif');
        });
    }
}
