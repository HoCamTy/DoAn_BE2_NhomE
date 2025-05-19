<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryServiceSeeder extends Seeder
{
    public function run(): void
    {
        $relationships = [
            ['category_id' => 1, 'service_id' => 1],
            ['category_id' => 1, 'service_id' => 2],
            ['category_id' => 1, 'service_id' => 3],
            ['category_id' => 2, 'service_id' => 4],
            ['category_id' => 2, 'service_id' => 5],
            ['category_id' => 2, 'service_id' => 6],
            ['category_id' => 2, 'service_id' => 7],
            ['category_id' => 3, 'service_id' => 8],
            ['category_id' => 3, 'service_id' => 9],
            ['category_id' => 4, 'service_id' => 10],
            ['category_id' => 4, 'service_id' => 11],
            ['category_id' => 4, 'service_id' => 12],
        ];

        foreach ($relationships as $relationship) {
            DB::table('category_service')->insert($relationship);
        }
    }
}
