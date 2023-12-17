<?php

namespace App\Services\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface NoteRepositoryInterface
{
    public function create(array $data): bool;
    public function update(array $data, int $id): bool;
    public function show(int $id): object;
    public function index(): Collection;
    public function delete(int $id): bool;

}
