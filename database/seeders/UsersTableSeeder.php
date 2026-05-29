<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {
        $users = [
            [
                'account_type'  => 'musician',
                'name'          => 'Carlos Ruiz',
                'email'         => 'carlos@gmail.com',
                'password'      => Hash::make('password'),
                'username'      => 'carlosruiz',
                'full_name'     => 'Carlos Ruiz Martínez',
                'city'          => 'Madrid',
                'general_level' => 4,
                'bio'           => 'Guitarrista con 10 años de experiencia. Me encanta el rock y el blues.',
                'age'           => 28,
                'has_band'      => false,
                'soundcloud_url'=> 'https://soundcloud.com/carlosruiz',
                'spotify_url'   => null,
            ],
            [
                'account_type'  => 'musician',
                'name'          => 'Laura Gómez',
                'email'         => 'laura@gmail.com',
                'password'      => Hash::make('password'),
                'username'      => 'lauragomez',
                'full_name'     => 'Laura Gómez Sánchez',
                'city'          => 'Barcelona',
                'general_level' => 3,
                'bio'           => 'Bajista y cantante. Busco banda de indie o pop alternativo.',
                'age'           => 25,
                'has_band'      => false,
                'soundcloud_url'=> null,
                'spotify_url'   => null,
            ],
            [
                'account_type'  => 'musician',
                'name'          => 'Marcos Díaz',
                'email'         => 'marcos@gmail.com',
                'password'      => Hash::make('password'),
                'username'      => 'marcosdiaz',
                'full_name'     => 'Marcos Díaz López',
                'city'          => 'Sevilla',
                'general_level' => 5,
                'bio'           => 'Baterista profesional. He tocado en varios festivales nacionales.',
                'age'           => 32,
                'has_band'      => true,
                'soundcloud_url'=> null,
                'spotify_url'   => 'https://open.spotify.com/artist/marcosdiaz',
            ],
            [
                'account_type'  => 'musician',
                'name'          => 'Ana Torres',
                'email'         => 'ana@gmail.com',
                'password'      => Hash::make('password'),
                'username'      => 'anatorres',
                'full_name'     => 'Ana Torres Fernández',
                'city'          => 'Valencia',
                'general_level' => 2,
                'bio'           => 'Pianista clásica reconvirtiéndome al jazz. Siempre aprendiendo.',
                'age'           => 22,
                'has_band'      => false,
                'soundcloud_url'=> null,
                'spotify_url'   => null,
            ],
            [
                'account_type'  => 'musician',
                'name'          => 'David Moreno',
                'email'         => 'david@gmail.com',
                'password'      => Hash::make('password'),
                'username'      => 'davidmoreno',
                'full_name'     => 'David Moreno García',
                'city'          => 'Bilbao',
                'general_level' => 3,
                'bio'           => 'Violinista y compositor. Me interesa fusionar clásico con electrónica.',
                'age'           => 30,
                'has_band'      => true,
                'soundcloud_url'=> 'https://soundcloud.com/davidmoreno',
                'spotify_url'   => null,
            ],
            [
                'account_type'  => 'musician',
                'name'          => 'Sara Jiménez',
                'email'         => 'sara@gmail.com',
                'password'      => Hash::make('password'),
                'username'      => 'sarajimenez',
                'full_name'     => 'Sara Jiménez Pérez',
                'city'          => 'Madrid',
                'general_level' => 4,
                'bio'           => 'Vocalista de metal y hard rock. Busco banda seria con ensayos regulares.',
                'age'           => 27,
                'has_band'      => false,
                'soundcloud_url'=> null,
                'spotify_url'   => null,
            ],
            [
                'account_type'  => 'band',
                'name'          => 'The Broken Strings',
                'email'         => 'brokenstrings@gmail.com',
                'password'      => Hash::make('password'),
                'username'      => 'brokenstrings',
                'full_name'     => null,
                'city'          => 'Barcelona',
                'general_level' => 4,
                'bio'           => 'Banda de rock alternativo formada en 2019. Buscamos bajista.',
                'age'           => null,
                'has_band'      => true,
                'soundcloud_url'=> 'https://soundcloud.com/brokenstrings',
                'spotify_url'   => 'https://open.spotify.com/artist/brokenstrings',
            ],
            [
                'account_type'  => 'musician',
                'name'          => 'Pablo Vega',
                'email'         => 'pablo@gmail.com',
                'password'      => Hash::make('password'),
                'username'      => 'pablovega',
                'full_name'     => 'Pablo Vega Castillo',
                'city'          => 'Málaga',
                'general_level' => 1,
                'bio'           => 'Empezando con la guitarra. Busco gente para aprender y tocar juntos.',
                'age'           => 19,
                'has_band'      => false,
                'soundcloud_url'=> null,
                'spotify_url'   => null,
            ],
        ];
 
        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}
