<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class GenreUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'carlosruiz'    => [1, 4, 14], 
            'lauragomez'    => [17, 2, 10],
            'marcosdiaz'    => [1, 7, 8],
            'anatorres'     => [3, 6, 18],
            'davidmoreno'   => [6, 13, 3],
            'sarajimenez'   => [7, 1, 8],
            'brokenstrings' => [1, 17, 8],
            'pablovega'     => [1, 14, 17],
        ];
 
        foreach ($data as $username => $genreIds) {
            $user = User::where('username', $username)->first();
 
            if (!$user) continue;
 
            $user->genres()->attach($genreIds);
        }
    }
}
