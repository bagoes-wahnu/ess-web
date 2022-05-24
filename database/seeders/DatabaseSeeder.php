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
            DinasSeeder::class,
            BerkasSeeder::class,
            BerkasKonsepSeeder::class,
            HariLiburSeeder::class,
            KecamatanSeeder::class,
            KelurahanSeeder::class,
            ProsesPermohonanSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            PermohonanSswSeeder::class,
            PermohonanSswPersyaratanFileSeeder::class,
        ]);
    }
}
