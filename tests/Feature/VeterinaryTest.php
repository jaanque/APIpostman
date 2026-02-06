<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Dueno;
use App\Models\Animal;

class VeterinaryTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_can_create_dueno()
    {
        $response = $this->postJson('/api/duenos', [
            'nombre' => 'Juan',
            'apellido' => 'Perez',
        ]);

        $response->assertStatus(201)
                 ->assertJson(['nombre' => 'Juan', 'apellido' => 'Perez']);

        $this->assertDatabaseHas('duenos', ['nombre' => 'Juan']);
    }

    public function test_api_can_create_animal()
    {
        $dueno = Dueno::create(['nombre' => 'Juan', 'apellido' => 'Perez']);

        $response = $this->postJson('/api/animales', [
            'nombre' => 'Firulais',
            'tipo' => 'perro',
            'peso' => 10.5,
            'enfermedad' => 'Ninguna',
            'comentarios' => 'Buen chico',
            'dueno_id' => $dueno->id,
        ]);

        $response->assertStatus(201)
                 ->assertJson(['nombre' => 'Firulais', 'tipo' => 'perro']);

        $this->assertDatabaseHas('animales', ['nombre' => 'Firulais']);
    }

    public function test_api_validates_animal_creation()
    {
        $response = $this->postJson('/api/animales', [
            'nombre' => 'Firulais',
            // Missing fields
        ]);

        $response->assertStatus(422);
    }

    public function test_cascade_delete()
    {
        $dueno = Dueno::create(['nombre' => 'Juan', 'apellido' => 'Perez']);
        $animal = Animal::create([
            'nombre' => 'Firulais',
            'tipo' => 'perro',
            'peso' => 10.5,
            'dueno_id' => $dueno->id
        ]);

        $this->assertDatabaseHas('duenos', ['id' => $dueno->id]);
        $this->assertDatabaseHas('animales', ['id' => $animal->id]);

        $response = $this->deleteJson("/api/duenos/{$dueno->id}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('duenos', ['id' => $dueno->id]);
        $this->assertDatabaseMissing('animales', ['id' => $animal->id]);
    }

    public function test_update_animal()
    {
        $dueno = Dueno::create(['nombre' => 'Juan', 'apellido' => 'Perez']);
        $animal = Animal::create([
            'nombre' => 'Firulais',
            'tipo' => 'perro',
            'peso' => 10.5,
            'dueno_id' => $dueno->id
        ]);

        $response = $this->putJson("/api/animales/{$animal->id}", [
            'nombre' => 'Rex',
            'tipo' => 'perro',
            'peso' => 12.0,
            'dueno_id' => $dueno->id
        ]);

        $response->assertStatus(200)
                 ->assertJson(['nombre' => 'Rex']);

        $this->assertDatabaseHas('animales', ['id' => $animal->id, 'nombre' => 'Rex']);
    }
}
