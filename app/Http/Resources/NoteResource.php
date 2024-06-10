<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'owner' => User::query()->find($this->user_id)->name,
            'title' => $this->title,
            'content' => $this->content,
            'created_at' => $this->created_at,

        ];
    }
}
