<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

class JabatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO mst_jabatan (id_mst_jabatan, nama_jabatan) VALUES
        (1, 'Kepala Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kabupaten  Pamekasan'),
        (2, 'Sekretaris Badan Kepegawaian dan Pengembangan Sumber Daya Manusia'),
        (3, 'Kasubbag Perencanaan , Umum dan Kepegawaian'),
        (4, 'Kasubbag keuangan dan Aset'),
        (5, 'Kepala Bidang Mutasi dan Promosi'),
        (6, 'Kepala Bidang Pengembangan Aparatur'),
        (7, 'Kepala Bidang Pengadaan, Pembinaan dan Informasi Kepegawaian'),
        (8, 'Analis SDM Aparatur Muda'),
        (9, 'Kepala Sub Bidang Pengadaan dan Pemberhentian'),
        (10, 'Analis Kepegawaian Ahli Pertama'),
        (11, 'Staf');
        ");
    }
}
