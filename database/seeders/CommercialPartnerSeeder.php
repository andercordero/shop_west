<?php

namespace Database\Seeders;

use App\Models\CommercialPartner;
use App\Models\State;
use Illuminate\Database\Seeder;

class CommercialPartnerSeeder extends Seeder
{
    /**
     * Datos de ejemplo para poder ver la sección funcionando.
     * Reemplazar por los aliados reales antes de publicar.
     */
    public function run(): void
    {
        $partners = [
            ['VEK', 'Aliado de ejemplo 1', 'Ferretería y materiales de construcción.', '+58 251-0000001', 'Av. Principal, Barquisimeto'],
            ['VEK', 'Aliado de ejemplo 2', 'Distribuidor de adhesivos y morteros.', '+58 251-0000002', 'Zona industrial, Barquisimeto'],
            ['VEK', 'Aliado de ejemplo 13', 'Acabados y revestimientos.', '+58 251-0000013', 'Av. Venezuela, Barquisimeto'],
            ['VEK', 'Aliado de ejemplo 14', 'Depósito de materiales.', '+58 251-0000014', 'Av. Lara, Cabudare'],
            ['VEK', 'Aliado de ejemplo 15', 'Ferretería y herramientas.', '+58 253-0000015', 'Av. Principal, Carora'],
            ['VET', 'Aliado de ejemplo 3', 'Depósito de materiales.', '+58 271-0000003', 'Calle 5, Valera'],
            ['VET', 'Aliado de ejemplo 4', 'Ferretería con línea completa Occidente.', '+58 271-0000004', 'Av. Bolívar, Trujillo'],
            ['VEV', 'Aliado de ejemplo 5', 'Mayorista de construcción.', '+58 261-0000005', 'Av. 15, Maracaibo'],
            ['VEV', 'Aliado de ejemplo 16', 'Distribuidor de adhesivos y morteros.', '+58 261-0000016', 'Av. 5 de Julio, Maracaibo'],
            ['VEV', 'Aliado de ejemplo 17', 'Ferretería y acabados.', '+58 261-0000017', 'Zona industrial, San Francisco'],
            ['VEV', 'Aliado de ejemplo 18', 'Depósito de cemento y adhesivos.', '+58 262-0000018', 'Av. Intercomunal, Ciudad Ojeda'],
            ['VEV', 'Aliado de ejemplo 19', 'Punto de venta autorizado.', '+58 263-0000019', 'Av. Principal, Machiques'],
            ['VEA', 'Aliado de ejemplo 6', 'Punto de venta autorizado.', '+58 212-0000006', 'Av. Urdaneta, Caracas'],
            ['VEG', 'Aliado de ejemplo 7', 'Ferretería y acabados.', '+58 241-0000007', 'Av. Bolívar Norte, Valencia'],
            ['VEL', 'Aliado de ejemplo 8', 'Materiales para obra.', '+58 274-0000008', 'Av. Las Américas, Mérida'],
            ['VEB', 'Aliado de ejemplo 9', 'Distribuidor regional.', '+58 281-0000009', 'Av. Intercomunal, Barcelona'],
            ['VEP', 'Aliado de ejemplo 10', 'Depósito de cemento y adhesivos.', '+58 255-0000010', 'Av. Libertador, Acarigua'],
            ['VEI', 'Aliado de ejemplo 11', 'Ferretería costera.', '+58 268-0000011', 'Av. Josefa Camejo, Coro'],
            ['VEM', 'Aliado de ejemplo 12', 'Punto de venta autorizado.', '+58 212-0000012', 'Guarenas, Miranda'],
        ];

        foreach ($partners as [$code, $name, $description, $phone, $address]) {
            $state = State::where('code', $code)->first();

            if (! $state) {
                continue;
            }

            CommercialPartner::updateOrCreate(
                ['name' => $name],
                [
                    'state_id' => $state->id,
                    'description' => $description,
                    'phone' => $phone,
                    'address' => $address,
                    'url' => 'https://www.google.com/maps/search/?api=1&query='.urlencode($address),
                    'active' => true,
                ],
            );
        }
    }
}
