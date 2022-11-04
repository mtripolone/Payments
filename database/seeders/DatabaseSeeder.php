<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
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
        User::factory(1)->create();

        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Geral',
            'profile' => 'user',
            'email' => 'admin@admin.com',
        ]);
    }
}
