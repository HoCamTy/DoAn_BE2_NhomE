<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;

class StaffSeeder extends Seeder
{
    public function run()
    {
        Staff::create(['name' => 'Nguyễn Văn Thành']);
        Staff::create(['name' => 'Trần Thị Mai']);
        Staff::create(['name' => 'Lê Thị Mỹ']);
        Staff::create(['name' => 'Đào Thị Trinh']);
        Staff::create(['name' => 'Lê Mỹ Quyền']);
    }
}

