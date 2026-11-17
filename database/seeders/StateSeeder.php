<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Los 23 estados, el Distrito Capital y las Dependencias Federales.
     * `code` es el ISO 3166-2:VE sin guion y debe coincidir con el id del
     * trazado en page/partials/mapa_venezuela.blade.php.
     */
    public function run(): void
    {
        $states = [
            ['VEZ', 'Amazonas'],
            ['VEB', 'Anzoátegui'],
            ['VEC', 'Apure'],
            ['VED', 'Aragua'],
            ['VEE', 'Barinas'],
            ['VEF', 'Bolívar'],
            ['VEG', 'Carabobo'],
            ['VEH', 'Cojedes'],
            ['VEY', 'Delta Amacuro'],
            ['VEA', 'Distrito Capital'],
            ['VEW', 'Dependencias Federales'],
            ['VEI', 'Falcón'],
            ['VEJ', 'Guárico'],
            ['VEX', 'La Guaira'],
            ['VEK', 'Lara'],
            ['VEL', 'Mérida'],
            ['VEM', 'Miranda'],
            ['VEN', 'Monagas'],
            ['VEO', 'Nueva Esparta'],
            ['VEP', 'Portuguesa'],
            ['VER', 'Sucre'],
            ['VES', 'Táchira'],
            ['VET', 'Trujillo'],
            ['VEU', 'Yaracuy'],
            ['VEV', 'Zulia'],
        ];

        foreach ($states as [$code, $name]) {
            State::updateOrCreate(
                ['code' => $code],
                ['name' => $name, 'description' => $name.', Venezuela', 'active' => true],
            );
        }
    }
}
