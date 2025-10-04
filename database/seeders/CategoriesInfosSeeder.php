<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoriesInfosSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();       
        
        DB::table('categories_infos')->insert([
            [
                'a_username' => 'Afifa',
                'categories_name' => 'Fruits',
                'categories_description' => "that's for fruits",
                'categories_status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'a_username' => 'Afifa',
                'categories_name' => 'Vegetables',
                'categories_description' => "that's for vegetables",
                'categories_status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'a_username' => 'Afifa',
                'categories_name' => 'Seeds',
                'categories_description' => "that's for seeds",
                'categories_status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'a_username' => 'Afifa',
                'categories_name' => 'Cash Crops',
                'categories_description' => "that's for cash",
                'categories_status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'a_username' => 'Afifa',
                'categories_name' => 'Flowers',
                'categories_description' => "that's for flowers",
                'categories_status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'a_username' => 'Afifa',
                'categories_name' => 'Saplings',
                'categories_description' => "that's for Sapling",
                'categories_status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
