<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenandaTanganSuratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penanda_tangan_surat', function (Blueprint $table) {
            $table->bigIncrements('id_penanda_tangan_surat');
            $table->string('level_pengguna');
            $table->integer('pengguna_id');
            $table->string('tte')->nullable();
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
        Schema::dropIfExists('penanda_tangan_surat');
    }
}
