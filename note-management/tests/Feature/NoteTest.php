<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NoteTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private function getToken()
    {
        $response = $this->post('/api/login', [
            'email' => 'beshoysedkey17371@gmail.com',
            'password' => '123456789',
        ]);

        $token = $response->json('token');
        return $token;
    }

    public function testNoteCanBeCreated()
    {
        $users = User::pluck('id')->values();

        $data = [
            'title' => $this->faker->title,
            'content' => $this->faker->text,
            'user_id' => $users->random()
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getToken(),
        ])->post('/api/note', $data);

        $this->assertDatabaseHas('notes', $data);
        $response->assertStatus(201);
    }

    public function testNoteCanBeDeleted()
    {
        $note = Note::create([
            'title' => 'Test Note',
            'content' => 'This is a test note.',
            'user_id' => 109
        ]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getToken(),
        ])->delete("/api/note/{$note->id}");

        $response->assertStatus(202);
    }
}
