<?php
namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateWargaDummy extends Seeder
{

    public function run(): void
    {
        $faker      = Factory::create('id_ID');
        $jumlahData = 100;

        foreach (range(1, $jumlahData) as $index) {

            // Generate Jenis Kelamin dan Pekerjaan yang sesuai
            $jenisKelamin = $faker->randomElement(['Laki-laki', 'Perempuan']);
            $pekerjaan    = $faker->randomElement(['PNS', 'Swasta', 'Wiraswasta', 'Pelajar/Mahasiswa', 'Ibu Rumah Tangga']);

            DB::table('warga')->insert([
                'no_ktp'        => $faker->unique()->numerify('################'), // 16 digit KTP
                'nama'          => $faker->name($jenisKelamin == 'Laki-laki' ? 'Laki-laki' : 'Perempuan'),
                'jenis_kelamin' => $jenisKelamin,
                'agama'         => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']),
                'pekerjaan'     => $pekerjaan,
                'telp'          => $faker->unique()->numerify('08##########'),
                'email'         => $faker->unique()->safeEmail,

                // Tambahkan timestamps karena DB::table tidak mengisinya otomatis
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
        $this->command->info("{$jumlahData} Data Warga berhasil ditambahkan.");
    }
}
