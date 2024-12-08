<?php

namespace Database\Seeders;

use App\Models\MetodoPago;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TarjetaDatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $metodos = ['tarjeta', 'efectivo', 'giros'];

        foreach ($metodos as $metodo) {
            MetodoPago::create([
                'metodo' => $metodo
            ]);
        }
    }
}
