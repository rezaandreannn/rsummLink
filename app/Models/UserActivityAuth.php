<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserActivityAuth extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'login_at' => 'datetime',
        'logout_at' => 'datetime',
    ];

    public function scopeByAuthId($query)
    {
        return $query->where('user_id', Auth::id())
            ->whereNull('logout_at')
            ->latest('login_at')
            ->first();
    }
}
