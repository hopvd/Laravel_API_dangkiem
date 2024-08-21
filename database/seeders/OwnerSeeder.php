<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        DB::table('owners')->delete();
        $owners = [
            ['name' => 'Hop', 'phone' => '0987654', 'address' => 'LV', 'cccd' => '000000', 'type' => 1],
            ['name' => 'Huy', 'phone' => '7654', 'address' => 'LV', 'cccd' => '1100000', 'type' => 1]
        ];
        DB::table('owners')->insert($owners);
    }
}
