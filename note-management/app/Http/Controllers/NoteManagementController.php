<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Http\Resources\NoteManagementResource;
use App\Models\Note;
use App\Services\Repositories\NoteRepositoryInterface;
use App\Traits\GeneralReturn;
use Illuminate\Http\Request;

class NoteManagementController extends Controller
{
    use GeneralReturn;
    /**
     * @var NoteRepositoryInterface
     */
    protected NoteRepositoryInterface $noteRepositoryInterface;

    /**
     *__construct
     * @param NoteRepositoryInterface $noteRepositoryInterface
     */
    public function __construct(NoteRepositoryInterface $noteRepositoryInterface)
    {
        $this->noteRepositoryInterface = $noteRepositoryInterface;
    }

    /**
     *
     * @param Request $request
     *
     * @return [type]
     */
    public function create(CreateNoteRequest $request)
    {

        $this->noteRepositoryInterface->create($request->validated());
        return $this->Success201('Note');
    }

    /**
     * update
     * @param UpdateNoteRequest $request
     * @param Note $note
     *
     * @return [type]
     */
    public function update(UpdateNoteRequest $request, Note $note)
    {
        $this->noteRepositoryInterface->update($request->validated(), $note->id);
        return $this->Success202('Note');
    }


    /**
     * index
     * @return NoteManagementResource
     */
    public function index()
    {
        $notes =  $this->noteRepositoryInterface->index();
        return $this->Success200(
            NoteManagementResource::collection($notes)
        );
    }

    /**
     * show
     * @param Note $note
     *
     * @return NoteManagementResource
     */
    public function show(Note $note)
    {
        $note = $this->noteRepositoryInterface->show($note->id);
        return $this->Success200(
            new NoteManagementResource($note)
        );
    }

    /**
     * show
     * @param Note $note
     *
     * @return NoteManagementResource
     */
    public function delete(Note $note)
    {
        $note = $this->noteRepositoryInterface->delete($note->id);
        return $this->Success202('Note');
    }
}
