<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrPekerjaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_pekerjaan', function (Blueprint $table) {
          $table->bigIncrements('id_tr_pekerjaan');
          $table->integer('absensi_id');
          $table->string('nip');
          $table->string('nama_pekerjaan');
          $table->text('detail_pekerjaan');
          $table->string('foto_pekerjaan_1')->nullable();
          $table->string('foto_pekerjaan_2')->nullable();
          $table->string('foto_pekerjaan_3')->nullable();
          $table->softDeletes();
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
        Schema::dropIfExists('tr_pekerjaan');
    }
}
