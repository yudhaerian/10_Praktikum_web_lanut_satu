<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NilaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $nilai =[
            [

                'mahasiswa_nim' =>101,
                'matakuliah_id' =>1,
                'nilai' => 'A',
            ],
            [
                'mahasiswa_nim' =>101,
                'matakuliah_id' =>3,
                'nilai' => 'A',
            ],
            [
                'mahasiswa_nim' =>101,
                'matakuliah_id' =>4,
                'nilai' => 'A',
            ]

        ];

        DB::table('mahasiswa_matakuliah')->insert($nilai);
    }
}
