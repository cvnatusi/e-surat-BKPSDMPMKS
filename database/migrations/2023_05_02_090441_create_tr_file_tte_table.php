<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrFileTteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_file_tte', function (Blueprint $table) {
            $table->bigIncrements('id_file_surat');
            $table->string('nama_surat');
            $table->date('tanggal_surat');
            $table->integer('penanda_tangan_id');
            $table->string('file_surat')->nullable();
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
        Schema::dropIfExists('tr_file_tte');
    }
}
