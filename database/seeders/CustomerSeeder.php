<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'customer_name' => 'Nguyễn Lê Kim Hoàng',
                'phone' => '033445578',
                'email' => 'kimhoang@gmail.com',
                'address' => '27 Chương Dương , Linh Chiểu , Thủ Đức , Hồ Chí Minh',
                'password' => Hash::make('password123'),
                'create_date' => '2024-12-10 10:28:12'
            ],
            [
                'customer_name' => 'Trần Thị Hoàng Yến',
                'phone' => '035544127',
                'email' => 'hoangyen@gmail.com',
                'address' => '8 Nguyễn Huy Tưởng , Phường 6 , Quận Bình Thạnh , Thành Phố Hồ Chí Minh',
                'password' => null,
                'create_date' => '2024-12-10 10:28:12'
            ],
            [
                'customer_name' => 'Nguyễn Thị Yến Nhi',
                'phone' => '0334455781',
                'email' => 'mai@gmail.com',
                'address' => '45 Võ Văn Ngân , Linh Chiểu , Thủ Đức , Thành Phố Hồ Chí Minh',
                'password' => Hash::make('customer789'),
                'create_date' => '2024-12-10 10:29:31'
            ]
        ];

        foreach ($customers as $customer) {
            DB::table('customers')->insert($customer);
        }
    }
}
