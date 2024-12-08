<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Proveedore;
use App\Models\Publicar;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(5)->create();
        Proveedore::factory(10)->create();
        Categoria::factory(4)->create();
        Producto::factory(20)->create();
        Publicar::factory(5)->create();
        $this->call(DepartamentoSeeder::class);
        $this->call(CiudadeSeeder::class);
        $this->call(TarjetaDatoSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
