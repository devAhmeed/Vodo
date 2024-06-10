<?php

namespace App\Http\Requests\Api\Note;

use App\Models\Note;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\NoteResource;
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


    public function update($id) {
        try {
            $data = $this->validated();
            $note = Note::query()->find($id);
            $user = auth()->user();
            if (!$note) return apiResponse(false, __('note.not_found'), null, 'bad_request');
            if($note->user_id != $user->id) return apiResponse(false,__('note.unauthorized_access'),null,'unauthorized_access');
            DB::beginTransaction();
            $note->update($data);
            $note->refresh();
            \DB::commit();
            return apiResponse(true, __('note.updated'), new NoteResource($note),'ok');
        } catch (\Exception $e) {
            \DB::rollBack();
            return apiResponse(false, __('note.error'), null, 'bad_request');
        }
    }
}
