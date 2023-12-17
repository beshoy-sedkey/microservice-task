<?php

namespace App\Services\Repositories;

use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;

class NoteRepository implements NoteRepositoryInterface
{
    protected $note;
    public function __construct(Note $note)
    {
        $this->note = $note;
    }
    /**
     * create
     * @param array $data
     *
     * @return bool
     */
    public function create(array $data): bool
    {
        try {
            return $this->note->create($data);
        } catch (\Throwable $th) {
            return  $th->getMessage();
        }
    }

    /**
     * update
     * @param array $data
     * @param int $id
     *
     * @return bool
     */
    public function update(array $data, int $id): bool
    {
        try {
            return $this->note->where('id' , $id)->update($data);
        } catch (\Throwable $th) {
            return  $th->getMessage();
        }
    }

    /**
     * show
     * @param int $id
     *
     * @return object
     */
    public function show(int $id): object
    {
        try {
            return $this->note->findOrFail($id);
        } catch (\Throwable $th) {
            return  $th->getMessage();
        }
    }

    /**
     * index
     * @return Collection
     */
    public function index(): Collection
    {
        try {
            return $this->note->get();
        } catch (\Throwable $th) {
            return  $th->getMessage();
        }
    }

    /**
     * delete
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        try {
            return $this->note->destroy($id);
        } catch (\Throwable $th) {
            return  $th->getMessage();
        }
    }

}
