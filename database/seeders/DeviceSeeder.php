<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('devices')->insert([
            [
                'name' => 'Máy đo vận tốc',
                'quantity' => 5,
                'image' => 'device1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
