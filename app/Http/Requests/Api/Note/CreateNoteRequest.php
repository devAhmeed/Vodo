<?php

namespace App\Http\Requests\Api\Note;

use App\Models\Note;
use App\Http\Resources\NoteResource;
use Illuminate\Foundation\Http\FormRequest;

class CreateNoteRequest extends FormRequest
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
            'content' => 'required|string',
        ];
    }


    public function store()
    {
        //try {
            $data = $this->validated();
            $data['user_id'] = auth()->user()->id;
            $note = Note::query()->create($data);
            return apiResponse(true, __('note.created'), new NoteResource($note), 'created');
        //} catch (\Exception $e) {
            return apiResponse(false, __('note.error'), null, 'bad_request');
        //}
    }
}
