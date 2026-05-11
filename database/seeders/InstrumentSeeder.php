<?php

namespace Database\Seeders;

use App\Models\Instrument;
use Illuminate\Database\Seeder;

class InstrumentSeeder extends Seeder
{
    public function run(): void
    {
        $instruments = [
            'Guitarra eléctrica', 'Guitarra acústica', 'Guitarra clásica',
            'Bajo', 'Batería', 'Teclado', 'Piano', 'Violín',
            'Saxofón', 'Trompeta', 'Trombón', 'Flauta',
            'Voz', 'Ukelele', 'Mandolina', 'Contrabajo',
            'Armónica', 'Acordeón', 'Percusión', 'DJ / Producción',
        ];

        foreach ($instruments as $instrument) {
            Instrument::create(['name' => $instrument]);
        }
    }
}