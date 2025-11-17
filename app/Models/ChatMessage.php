<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'sender_name',
        'sender_role',
        'body',
        'is_owner',
        'sent_at',
    ];

    protected $casts = [
        'is_owner' => 'boolean',
        'sent_at' => 'datetime',
    ];
}
