<?php

namespace Tests\Unit;

use Mockery;
use App\Models\User;
use PHPUnit\Framework\TestCase;
use App\Services\Repository\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCreation()
    {
        $mockUserRepo = Mockery::mock(UserRepository::class);
        $user = User::factory()->create();
        $mockUserRepo->shouldReceive('create')
            ->once()
            ->with([
                'name' => $user->name,
                'email' => $user->email,
                'password' => '123456789',
            ])
            ->andReturn(User::create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => '123456789',
            ]));

        $service = new UserRepository($mockUserRepo);

        $user = $service->create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => '123456789',
        ]);

        // Assertions
        $this->assertInstanceOf(User::class, $user);
    }
}
