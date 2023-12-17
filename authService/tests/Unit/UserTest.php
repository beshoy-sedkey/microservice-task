<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use App\Services\Repository\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class UserTest extends TestCase
{
    use WithFaker , RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // other setup code
    }

    /** @test */
    public function it_registers_a_user()
    {
        Event::fake();

        DB::shouldReceive('table')
            ->with('users')
            ->andReturnSelf()
            ->shouldReceive('insertGetId')
            ->andReturn(1, 2, 3); // Mock the returned user IDs

        $userService = new UserRepository();

        // Prepare the data for the new users
        $usersData = [
            [
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'password' => Hash::make('password'),
            ],
            [
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'password' => Hash::make('password'),
            ],
            // Add more user data as needed
        ];

        foreach ($usersData as $userData) {
            // Call the registration method in the UserService
            $user = $userService->create($userData);

            // Assert the user object
            $this->assertInstanceOf(\App\Models\User::class, $user);
        }
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
