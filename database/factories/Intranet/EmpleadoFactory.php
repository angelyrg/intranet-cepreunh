<?php

namespace Database\Factories\Intranet;

use App\Models\Intranet\Empleado;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empleado>
 */
class EmpleadoFactory extends Factory
{

    protected $model = Empleado::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tipo_documento_id' => $this->faker->randomElement([1, 2, 3]), // IDs que correspondan a los tipos de documento
            'nro_documento' => $this->faker->unique()->numerify('########'), // 8 dígitos de documento
            'nombres' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'apellido_paterno' => $this->faker->lastName,
            'apellido_materno' => $this->faker->lastName,
            'fecha_nacimiento' => $this->faker->date('Y-m-d', '2000-01-01'), // Fecha en formato Y-m-d
            'pais_nacimiento' => $this->faker->randomElement([140, 141, 142]), // IDs que correspondan a los países
            'telefono_personal' => $this->faker->phoneNumber,
            'whatsapp' => $this->faker->phoneNumber,
            'correo_personal' => $this->faker->unique()->safeEmail,
            'correo_institucional' => $this->faker->optional()->safeEmail,
            'departamento_id' => $this->faker->randomElement([1]), // IDs de departamentos
        ];
    }
}
