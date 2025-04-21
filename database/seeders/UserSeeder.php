<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; 
use App\Models\TpUsuario; 
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {// Obtén los roles existentes en la base de datos
        $adminRole = TpUsuario::where('rol', 'Administrador')->first();
        $diaRole = TpUsuario::where('rol', 'trabajador-dia')->first();
        $nocheRole = TpUsuario::where('rol', 'trabajador-noche')->first();
        $cajeroRole = TpUsuario::where('rol', 'cajero')->first();

        // Crear solo los usuarios necesarios con los campos esenciales

        // Usuario 1: Administrador
        User::create([
            'name' => 'Administrador',
            'id_rol' => $adminRole->id,  // Asignar id del rol existente
            'email' => 'astridcarolina@gmail.com',
            'password' => Hash::make('81405cfF1@'),
        ]);

        // Usuario 2: Trabajador día
        User::create([
            'name' => 'Trabajador Día',
            'id_rol' => $diaRole->id,  // Asignar id del rol existente
            'email' => 'deliciachinapiedecuesta@gmail.com',
            'password' => Hash::make('comidachina2024'),
        ]);

        // Usuario 3: Trabajador noche
        User::create([
            'name' => 'Trabajador Noche',
            'id_rol' => $nocheRole->id,  // Asignar id del rol existente
            'email' => 'carlotachina946@gmail.com',
            'password' => Hash::make('comidachina2024'),
        ]);

        // Usuario 4: Cajero
        User::create([
            'name' => 'Cajero',
            'id_rol' => $cajeroRole->id,  // Asignar id del rol existente
            'email' => 'deliciachinapersonal@gmail.com',
            'password' => Hash::make('81405cfF1'),
        ]);
    }
    
}
