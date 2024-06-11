<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Note\CreateNoteRequest;
use App\Http\Requests\Web\Note\UpdateNoteRequest;

class NoteController extends Controller
{
    /**
     * Display a listing of the notes to authenticated user.
     */
    public function manage()
    {
        return view('Notes.manage', ['notes' => auth()->user()->notes()->get()]);
    }

    /**
     * Show the form for creating a new note.
     */
    public function create()
    {
        return view('Notes.create');
    }

    /**
     * Store a newly created note in storage.
     */
    public function store(CreateNoteRequest $request)
    {
        return $request->store();
    }

    /**
     * Display the form to update specified note.
     */
    public function edit(string $id)
    {
        $note = auth()->user()->notes()->find($id);

        if(!$note) return redirect(route('home'))->with('message', 'Note Not Found');

        return view('Notes.edit', ['note' =>$note ]);
    }


    /**
     * Update the specified note in storage.
     */
    public function update(UpdateNoteRequest $request, string $id)
    {
        return $request->update($id);
    }

    /**
     * Delete the specified note from storage.
     */
    public function delete(string $id)
    {
        $note = auth()->user()->notes()->find($id);

        if(!$note) return redirect(route('home'))->with('message', 'Note Not Found');

        $note->delete();
        return back()->with('message', 'Note Deleted Successfully');
    }
}
