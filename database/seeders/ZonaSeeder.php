<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('zonas')->insert([
            'nombre' => 'PRESIDENTES DE TSJ',
            'color' => '#D91729',
        ]);
        DB::table('zonas')->insert([
            'nombre' => 'LEGISLADORES LOCALES Y FEDERALES',
            'color' => '#E6ED02',
        ]);
        DB::table('zonas')->insert([
            'nombre' => 'PONENTES',
            'color' => '#5AD235',
        ]);
        DB::table('zonas')->insert([
            'nombre' => 'CONSEJEROS Y MAGISTRADOS PJPUEBLA',
            'color' => '#87202D',
        ]);
        DB::table('zonas')->insert([
            'nombre' => 'GABINETE ESTATAL',
            'color' => '#DFAD0C',
        ]);
        DB::table('zonas')->insert([
            'nombre' => 'PUBLICO EN GENERAL',
            'color' => '#D6AAED',
        ]);
    }
}
