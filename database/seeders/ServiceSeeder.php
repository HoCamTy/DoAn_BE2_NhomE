<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['service_name' => 'Massage mặt', 'price' => 39.00, 'service_duration' => 10],
            ['service_name' => 'Tẩy da chết mặt', 'price' => 59.00, 'service_duration' => 20],
            ['service_name' => 'Nặn mụn', 'price' => 89.00, 'service_duration' => 15],
            ['service_name' => 'Sơn móng', 'price' => 159.00, 'service_duration' => 30],
            ['service_name' => 'Tạo kiểu đính đá', 'price' => 49.00, 'service_duration' => 25],
            ['service_name' => 'Đắp móng', 'price' => 89.00, 'service_duration' => 40],
            ['service_name' => 'Cắt da chết', 'price' => 69.00, 'service_duration' => 20],
            ['service_name' => 'Gội đầu dưỡng sinh', 'price' => 129.00, 'service_duration' => 35],
            ['service_name' => 'Gội đầu massage', 'price' => 99.00, 'service_duration' => 30],
            ['service_name' => 'Triệt lông cánh tay', 'price' => 299.00, 'service_duration' => 45],
            ['service_name' => 'Triệt lông chân', 'price' => 309.00, 'service_duration' => 50],
            ['service_name' => 'Triệt lông toàn thân', 'price' => 999.00, 'service_duration' => 90],
        ];

        foreach ($services as $service) {
            DB::table('services')->insert(array_merge($service, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
