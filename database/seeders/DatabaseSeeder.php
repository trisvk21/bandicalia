<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            GenreSeeder::class,
            InstrumentSeeder::class,
            UsersTableSeeder::class,
            InstrumentUserSeeder::class,
            GenreUserSeeder::class,
            AdsTableSeeder::class,
            FollowsTableSeeder::class,
        ]);
    }
}