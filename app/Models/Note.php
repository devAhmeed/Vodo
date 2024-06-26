<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'user_id',

    ];

        /**
     * Get the User of specific note.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
