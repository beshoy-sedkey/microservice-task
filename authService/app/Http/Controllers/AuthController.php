<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Jobs\TestJob;
use App\Jobs\UserCrated;
use Illuminate\Http\Request;
use App\Jobs\NewUserRegistered;
use App\Events\UserCreatedEvent;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\LoginRequest;
use PhpAmqpLib\Message\AMQPMessage;
use App\Http\Requests\RegisterRequest;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use App\Services\Repository\UserRepositoryInterface;
use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Jobs\RabbitMQJob;

class AuthController extends Controller
{

    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * register
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->userRepository->create($request->all());
        event(new UserCreatedEvent($user));
        $token = $this->generateToken($user);
        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    /**
     * Handle a login request to the application.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        $token = $this->userRepository->attemptLogin($credentials);
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return response()->json(['token' => $token]);
    }

    /**
     * Generate a token for the given user.
     *
     * @param User $user
     * @return string
     */
    protected function generateToken($user): string
    {
        return JWTAuth::fromUser($user);
    }
}
