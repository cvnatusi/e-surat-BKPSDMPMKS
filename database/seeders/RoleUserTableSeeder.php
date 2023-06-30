<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO mst_dengan_harap (id_mst_dengan_harap, nama_dengan_harap) VALUES
        (1, 'Saya Hadir'),
        (2, 'Hadiri / Wakili'),
        (3, 'Pertimbangkan'),
        (4, 'Pedomani'),
        (5, 'Sarankan'),
        (6, 'Koordinasikan'),
        (7, 'Tindaklanjuti'),
        (8, 'Selesaikan'),
        (9, 'Siapkan'),
        (10, 'Untuk Diketahui'),
        (11, 'Untuk Diproses'),
        (12, 'Menghadap Saya'),
        (13, 'Laporkan Hasilnya'),
        (14, 'Monitor Pelaksanaanya'),
        (15, 'Sampaikan Kepada Ybs'),
        (16, 'Agendakan');
        ");
    }
}
