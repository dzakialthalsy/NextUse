<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'reviewed_user_id',
        'reviewer_id',
        'rating',
        'title',
        'review_text',
        'images',
        'show_name',
        'transaction_id',
    ];

    protected $casts = [
        'images' => 'array',
        'show_name' => 'boolean',
        'rating' => 'integer',
    ];

    /**
     * Get the user being reviewed.
     */
    public function reviewedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_user_id');
    }

    /**
     * Get the user who wrote the review.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}

