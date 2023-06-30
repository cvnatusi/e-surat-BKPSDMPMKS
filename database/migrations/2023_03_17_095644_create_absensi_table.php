<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('absensi', function (Blueprint $table) {
        $table->bigIncrements('id_absensi');
        $table->string('nip');
        $table->datetime('jam_checkinout');
        $table->integer('checktype');
        $table->integer('verfycode');
        $table->string('sn_finger')->nullable();
        $table->string('latitude_masuk')->nullable();
        $table->string('longitude_masuk')->nullable();
        $table->string('latitude_keluar')->nullable();
        $table->string('longitude_keluar')->nullable();
        $table->integer('absensi_id_tapman')->nullable();
        $table->softDeletes();
        $table->timestamps();
      });
    }
    // {
    //   Schema::create('absensi', function (Blueprint $table) {
    //     $table->bigIncrements('id_absensi');
    //     $table->string('nip');
    //     $table->date('date_shift');
    //     $table->time('jam_mulai_shift')->nullable();
    //     $table->time('jam_akhir_shift')->nullable();
    //     $table->date('tanggal_masuk')->nullable();
    //     $table->time('jam_masuk')->nullable();
    //     $table->date('tanggal_keluar')->nullable();
    //     $table->time('jam_keluar')->nullable();
    //     $table->string('latitude_masuk')->nullable();
    //     $table->string('longitude_masuk')->nullable();
    //     $table->string('latitude_keluar')->nullable();
    //     $table->string('longitude_keluar')->nullable();
    //     $table->integer('absensi_id_tapman')->nullable();
    //     $table->softDeletes();
    //     $table->timestamps();
    //   });
    // }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absensi');
    }
}
