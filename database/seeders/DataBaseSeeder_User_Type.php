<?php

namespace Database\Seeders;

use App\Models\User_Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataBaseSeeder_User_Type extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('user__types')->insert([
        'id' => '1',
        'role' => 'Administrador'
       ]);

        DB::table('user__types')->insert([
        'id' => '2',
        'role' => 'Cliente'
       ]);
    }
}
