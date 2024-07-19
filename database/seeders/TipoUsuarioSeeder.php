<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipo_usuarios')->insert([
            'nombre' => 'superadmin',
        ]);
        DB::table('tipo_usuarios')->insert([
            'nombre' => 'administrador',
        ]);
        DB::table('tipo_usuarios')->insert([
            'nombre' => 'usuario_acceso',
        ]);
        DB::table('tipo_usuarios')->insert([
            'nombre' => 'usuario_estacionamiento',
        ]);
    }
}
