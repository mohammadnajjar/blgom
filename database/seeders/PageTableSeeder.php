<?php

namespace Database\Seeders;

use App\Models\Page;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        Page::create([
            'title' => 'About Us',
            'description' => $faker->paragraph,
            'post_status' => 0,
            'comment_able' => 1,
            'post_type' => 'page',
            'post_status' => 1,
            'user_id' => 1,
            'category_id' => 1,
        ]);
        Page::create([
            'title' => 'Our Vision',
            'description' => $faker->paragraph,
            'post_status' => 0,
            'comment_able' => 1,
            'post_type' => 'page',
            'post_status' => 1,
            'user_id' => 1,
            'category_id' => 1,
        ]);
    }
}
