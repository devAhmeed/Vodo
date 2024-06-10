<?php

namespace App\Http\Controllers\Api;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NoteResource;
use App\Http\Requests\Api\Note\CreateNoteRequest;
use App\Http\Requests\Api\Note\UpdateNoteRequest;

class NoteController extends Controller
{
    /**
     * Display a listing Current Logged In User Notes.
     */
    public function index(Request $request)
    {
        $notes = Note::query()->where('user_id',auth()->user()->id)
        ->orderByDesc('created_at')
        ->get();

        return apiResponse(true, __('messages.success'), NoteResource::collection($notes)->response()->getData());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(CreateNoteRequest $request)
    {
        // Create New Note
        return $request->store();
    }

    /**
     * Update the specified note for the current logged in user.
     */
    public function update(UpdateNoteRequest $request, string $id)
    {
        return $request->update($id);
    }

    /**
     * Permanent delete the specified note.
     */
    public function delete(string $id)
    {
        $user = auth()->user();
        $note = Note::query()->withTrashed()->find($id);

        if($note->user_id != $user->id) return apiResponse(false,__('note.unauthorized_access'),null,'unauthorized_access');

        $note->forceDelete();

        return apiResponse(true,__('messages.deleted'),null,'no_content');
    }
}
