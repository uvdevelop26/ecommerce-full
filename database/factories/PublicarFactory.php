<?php

namespace Database\Factories;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publicar>
 */
class PublicarFactory extends Factory
{
    protected static $productoIds = null;


    public function definition()
    {
        // Cargar los IDs de productos una sola vez
        if (is_null(self::$productoIds)) {
            self::$productoIds = Producto::pluck('id')->toArray();
        }

        // Asegurarse de que queden productos disponibles
        if (empty(self::$productoIds)) {
            throw new \Exception('No hay más productos disponibles para asignar a las publicaciones.');
        }

        // Tomar un producto aleatorio y eliminarlo de la lista
        $productoId = array_splice(self::$productoIds, array_rand(self::$productoIds), 1)[0];

        $userId = User::pluck('id')->random();

        return [
            'precio_venta' => $this->faker->numberBetween(2000, 60000),
            'detalle' => $this->faker->sentence(),
            'estado' => true,
            'imagen_url' => $this->faker->imageUrl(),
            'producto_id' => $productoId,
            'user_id' => $userId,
        ];
    }
}
