<?php

namespace App\Models;

use App\Models\UserActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserActivityDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_activity_id',
        'ip_address',
        'device',
        'browser'
    ];

    public function userActivity()
    {
        return $this->belongsTo(UserActivity::class);
    }
}
