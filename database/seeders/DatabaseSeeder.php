<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RolesTableSeeder::class);
//        $this->call(PermissionTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(PostTableSeeder::class);
        $this->call(PageTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
    }
}
