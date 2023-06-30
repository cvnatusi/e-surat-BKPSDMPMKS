<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $this->call([
        ProvinsiTableSeeder::class,
        KabupatenTableSeeder::class,
        KecamatanTableSeeder::class,
        DesaTableSeeder::class,
        JabatanTableSeeder::class,
        DenganHarapTableSeeder::class,
        JenisSuratTableSeeder::class,
      ]);
    }
}
