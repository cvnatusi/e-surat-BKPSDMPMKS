<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstAsnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_asn', function (Blueprint $table) {
          $table->bigIncrements('id_mst_asn');
          $table->string('nama_asn');
          $table->string('nip', 18);
          $table->string('pangkat_golongan');
          $table->integer('jabatan');
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
        Schema::dropIfExists('mst_asn');
    }
}
