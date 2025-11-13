<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Organization extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'organization_name',
        'organization_type',
        'organization_id',
        'email',
        'phone',
        'contact_person',
        'password',
        'document_path',
        'email_verified_at',
        'is_active',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Automatically hash the password whenever it is set.
     */
    public function setPasswordAttribute(?string $value): void
    {
        if (empty($value)) {
            return;
        }

        // Avoid double hashing when the value is already hashed.
        $needsRehash = password_get_info($value)['algo'] === 0;

        $this->attributes['password'] = $needsRehash
            ? Hash::make($value)
            : $value;
    }
}
