<?php

namespace App\Http\Requests\Web\Note;

use App\Models\Note;
use Illuminate\Support\Facades\DB;
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

    public function store(){
        DB::beginTransaction();
        try {
            $data = $this->validated();
            $data['user_id'] = auth()->user()->id;
            $note = Note::query()->create($data);
            DB::commit();
            return back()->with('message', "Note Created Successfully");

        } catch (\Exception $e) {
            DB::rollBack();
        return back()->withErrors(['message' => 'Error While Create Note']);
        }
    }
}
