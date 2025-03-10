<?php

namespace Database\Seeders;

use App\Models\Courier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourierSeeder extends Seeder
{
    public function run(): void
    {
        Courier::factory(48)->create();

        Courier::insert([
            [
                'name' => 'Budiono Hadi Agung',
                'code' => 'KR001',
                'phone' => '081298765432',
                'email' => 'budiono.hadi@example.com',
                'sim_number' => 'SIM987654321',
                'address' => 'Jl. Diponegoro No. 10, Surabaya',
                'level' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Agung Prasetyo',
                'code' => 'KR002',
                'phone' => '081234567890',
                'email' => 'agung.prasetyo@example.com',
                'sim_number' => 'SIM123456789',
                'address' => 'Jl. Merdeka No. 45, Jakarta',
                'level' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
