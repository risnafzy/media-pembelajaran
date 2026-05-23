<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::create([
        'name' => 'Guru 1',
        'email' => 'guru@gmail.com',
        'role' => 'guru',
        'password' => Hash::make('password')
    ]);
    }
}
