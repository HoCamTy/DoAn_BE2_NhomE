<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;

class StaffSeeder extends Seeder
{
    public function run()
    {
        DB::table('staffs')->insert([
            [
                'staff_name' => 'Nguyễn Văn A',
                'staff_phone' => '0909123456',
                'email' => 'nguyenvana@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_name' => 'Trần Thị B',
                'staff_phone' => '0911123456',
                'email' => 'tranthib@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_name' => 'Lê Văn C',
                'staff_phone' => '0932123456',
                'email' => 'levanc@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

