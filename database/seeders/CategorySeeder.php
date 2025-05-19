<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'category_name' => 'CHĂM SÓC DA MẶT',
                'description' => 'Bao gồm: Massage mặt, nặn mụn, tẩy da chết mặt, cạo lông mặt.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'LÀM MÓNG TAY CHÂN',
                'description' => 'Bao gồm: Sơn màu, tạo kiểu đính đá, đắp móng, dưỡng móng, cắt da chết.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'GỘI ĐẦU',
                'description' => 'Bao gồm: Gội đầu dưỡng sinh, gội đầu massage.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'TRIỆT LÔNG',
                'description' => 'Bao gồm: Triệt lông cánh tay, chân, toàn thân.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
