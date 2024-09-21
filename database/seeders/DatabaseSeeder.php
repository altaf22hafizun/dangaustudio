<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::create([
            'name' => 'Admin',
            'email' => 'dangaustudio@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('12341234'),
            'role' => 'admin',
            'telp' => '0812-3456-7890',
        ]);
    }
}
