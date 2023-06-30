<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrSuratDisposisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_surat_disposisi', function (Blueprint $table) {
          $table->bigIncrements('id_surat_disposisi');
          $table->integer('no_agenda_disposisi');
          $table->integer('surat_masuk_id');
          $table->integer('pemberi_disposisi_id');
          $table->integer('penerima_disposisi_id');
          $table->string('dengan_hormat_harap');
          $table->text('catatan_disposisi')->nullable();
          $table->enum('status', ['Belum', 'Ambil','Disposisi'])->default('Belum');
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
        Schema::dropIfExists('tr_surat_disposisi');
    }
}
