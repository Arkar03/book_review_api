<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        "book_id",
        "user_id",
        "rating",
        "created_at",
        "updated_at"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
   
}
