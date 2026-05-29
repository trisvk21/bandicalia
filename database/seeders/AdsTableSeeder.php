<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ad;

class AdsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $band = User::where('username', 'brokenstrings')->first();
 
        if (!$band) return;
 
        Ad::create([
            'user_id' => $band->id,
            'title'   => 'Buscamos bajista para banda de rock alternativo en Barcelona',
            'body'    => 'Somos The Broken Strings, una banda de rock alternativo formada en 2019 con base en Barcelona. Llevamos varios años tocando juntos y hemos participado en festivales locales. Buscamos un bajista con nivel intermedio o avanzado que tenga disponibilidad para ensayar los fines de semana. Valoramos la puntualidad, el compromiso y las ganas de crecer juntos. Si te gustan bandas como Muse, Radiohead o Placebo, encajarás perfectamente.',
        ]);
 
        Ad::create([
            'user_id' => $band->id,
            'title'   => 'Se busca teclista o pianista para completar formación',
            'body'    => 'The Broken Strings busca teclista o pianista para incorporarse a nuestra formación. Queremos añadir más capas sonoras a nuestro sonido y creemos que un teclado puede aportarnos mucho. No es necesario tener experiencia en bandas anteriores, pero sí un nivel mínimo intermedio. Ensayamos en local propio en el Poblenou los sábados por la tarde.',
        ]);
    }
}
