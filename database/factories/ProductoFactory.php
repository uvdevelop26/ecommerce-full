<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Proveedore;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $proveedorId = Proveedore::pluck('id')->random();
        $categoriaId = Categoria::pluck('id')->random();
        $userId = User::pluck('id')->random();

        return [
            'nombre_producto' => $this->faker->word(),
            'descripcion' => $this->faker->sentence(),
            'precio_compra' => $this->faker->numberBetween(1000, 50000),
            'stock' => $this->faker->numberBetween(1, 1000),
            'proveedore_id' => $proveedorId,
            'categoria_id' => $categoriaId,
            'user_id' => $userId
        ];  
    }
}
