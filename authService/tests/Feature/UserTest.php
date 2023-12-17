<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use WithFaker , RefreshDatabase;

    /**
     * @test
     */
    public function testUserCreation()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'password',
        ];

        $this->post('/api/register', $userData);

        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
        ]);
    }
}
