<?php

namespace App\Http\Requests\Web\Note;

use DB;
use App\Models\Note;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:50',
            'content' => 'required|string'
        ];
    }

    public function update( string $id ) {
        DB::beginTransaction();
        try {
            $data = $this->validated();
            $note = Note::query()->find($id);
            $user = auth()->user();
            if (!$note) return redirect(route('editNotes'))->with('message', 'Note Not Found');
            if($note->user_id != $user->id) return redirect(route('editNotes'))->with('message' , 'Unauthorized Access');

            $note->update($data);
            $note->refresh();
            DB::commit();
            return back()->with('message', "Note Updated Successfully !");

        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('message' , 'Error While Update Note');
        }
    }
}
