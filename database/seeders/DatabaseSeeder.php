<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        DB::table('user__types')->insert([
            'id' => '1',
            'role' => 'Administrador',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('user__types')->insert([
            'id' => '2',
            'role' => 'Cliente',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'user_type_id' => "1",
            "password" => "123456"
        ]);

    }
}
