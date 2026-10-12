<?php

namespace Database\Seeders;

use App\Models\BuatLaporan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker; 


class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        for ($i = 0; $i < 10; $i++) {
             buatlaporan::create([
                'nama' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'notelp' => $faker->phoneNumber,
                'date' => $faker->date,
                'time' => $faker->time,
                'foto' => null,
                'deskripsi' => $faker->paragraph,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
