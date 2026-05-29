<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class InstrumentUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
        $data = [
            'carlosruiz'    => [
                ['id' => 1, 'level' => 4], 
                ['id' => 2, 'level' => 3], 
            ],
            'lauragomez'    => [
                ['id' => 4,  'level' => 3], 
                ['id' => 13, 'level' => 3],
            ],
            'marcosdiaz'    => [
                ['id' => 5, 'level' => 5], 
                ['id' => 19,'level' => 4], 
            ],
            'anatorres'     => [
                ['id' => 7, 'level' => 4],
                ['id' => 6, 'level' => 2],
            ],
            'davidmoreno'   => [
                ['id' => 8,  'level' => 5],
                ['id' => 16, 'level' => 3],
            ],
            'sarajimenez'   => [
                ['id' => 13, 'level' => 4],
            ],
            'brokenstrings' => [
                ['id' => 1,  'level' => 4],
                ['id' => 13, 'level' => 3],
            ],
            'pablovega'     => [
                ['id' => 1, 'level' => 1],
            ],
        ];
 
        foreach ($data as $username => $instruments) {
            $user = User::where('username', $username)->first();
 
            if (!$user) continue;
 
            foreach ($instruments as $instrument) {
                $user->instruments()->attach($instrument['id'], [
                    'level' => $instrument['level'],
                ]);
            }
        }
    }
}
