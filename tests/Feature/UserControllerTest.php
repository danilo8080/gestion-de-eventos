<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testObtenerUsuarios()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $response = $this->get(route('obtener'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'nombre',
                'email',
                'apodo',
                'foto',
            ]
        ]);
    }

    public function testCrearUsuario()
    {
        $userData = [
            'nombre' => 'Test',
            'email' => 'test@test.com',
            'apodo' => 'test',
            'foto' => 'ruta',
            'password' => '123456test',
        ];

        $response = $this->post(route('create'), $userData);

        $response->assertStatus(201);
    }
}
