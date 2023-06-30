<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnEselonToMstAsn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst_asn', function (Blueprint $table) {
          $table->string('eselon')->nullable();
          $table->char('status_aktif')->default('Y')->nullable();
        });
    }
    // Sekda              = Eselon II
    // Sekretaris, Kaban  = Eselon III
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mst_asn', function (Blueprint $table) {
          $table->dropColumn('eselon');
          $table->dropColumn('status_aktif');
        });
    }
}
