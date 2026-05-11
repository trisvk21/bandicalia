<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            'Rock', 'Pop', 'Jazz', 'Blues', 'Flamenco',
            'Clásica', 'Metal', 'Punk', 'Reggae', 'Soul',
            'Funk', 'Hip-Hop', 'Electrónica', 'Folk', 'Country',
            'R&B', 'Indie', 'Bossa Nova', 'Salsa', 'Ska',
        ];

        foreach ($genres as $genre) {
            Genre::create(['name' => $genre]);
        }
    }
}