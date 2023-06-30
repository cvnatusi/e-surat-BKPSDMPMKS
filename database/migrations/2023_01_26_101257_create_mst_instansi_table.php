<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstInstansiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_instansi', function (Blueprint $table) {
          $table->bigIncrements('id_instansi');
          $table->string('kode_instansi');
          $table->string('nama_instansi');
          $table->text('alamat');
          $table->string('nama_kota');
          $table->string('no_telepon')->nullable();
          $table->string('no_fax')->nullable();
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
        Schema::dropIfExists('mst_instansi');
    }
}
