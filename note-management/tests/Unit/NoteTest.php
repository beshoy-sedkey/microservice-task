<?php

namespace Tests\Unit;

use Mockery;
use App\Models\Note;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Repositories\NoteRepository;

class NoteTest extends TestCase
{
    
    protected $noteMock;
    protected $noteService;

    public function setUp(): void
    {
        parent::setUp();
        $this->noteMock = Mockery::mock(Note::class);
        $this->noteService = new NoteRepository($this->noteMock);
    }

    public function testCreate()
    {
        $data = ['title' => 'Test Note', 'content' => 'This is a test note.'];
        $this->noteMock->shouldReceive('create')
                       ->with($data)
                       ->once()
                       ->andReturn(true);

        $result = $this->noteService->create($data);

        $this->assertTrue($result);
    }

    public function testUpdate()
    {
        $data = ['title' => 'Updated Note', 'content' => 'This note has been updated.'];
        $id = 1;

        $this->noteMock->shouldReceive('where')
                       ->with('id', $id)
                       ->once()
                       ->andReturn($this->noteMock);

        $this->noteMock->shouldReceive('update')
                       ->with($data)
                       ->once()
                       ->andReturn(true);

        $result = $this->noteService->update($data, $id);

        $this->assertTrue($result);
    }

    public function testIndex()
    {
        $collection = new Collection([new Note(), new Note()]);

        $this->noteMock->shouldReceive('get')
                       ->once()
                       ->andReturn($collection);

        $result = $this->noteService->index();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
    }

    public function testDelete()
    {
        $id = 1;

        $this->noteMock->shouldReceive('destroy')
                       ->with($id)
                       ->once()
                       ->andReturn(true);

        $result = $this->noteService->delete($id);

        $this->assertTrue($result);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
