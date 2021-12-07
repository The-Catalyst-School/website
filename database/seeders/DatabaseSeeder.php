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

        \App\Models\Page::create([
          'title' => 'Home',
        ]);
        \App\Models\Page::create([
          'title' => 'About',
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
