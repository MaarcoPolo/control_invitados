<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'nombre' => 'Marco Polo',
            'apellido_paterno' => 'Olivares',
            'apellido_materno' => 'Gonzalez',
            'username' => 'superadmin',
            'password' => 'password',
            'status' => 1,
            'tipo_usuario_id' => 1
        ]);
        DB::table('users')->insert([
            'nombre' => 'Guillermo',
            'apellido_paterno' => 'Manzano',
            'apellido_materno' => 'Hernandez',
            'username' => 'parking',
            'password' => 'password',
            'status' => 1,
            'tipo_usuario_id' => 4
        ]);
    }
}
