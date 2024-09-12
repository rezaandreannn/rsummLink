<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserActivity extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'activity_type', 'model_type', 'model_id', 'changes'];

    // public function scopeLoggedInUsers(Builder $query)
    // {
    //     return $query->select('user_activities.user_id', 'users.name', 'users.email') // Pilih kolom dari user_activities dan users
    //         ->join('users', 'users.id', '=', 'user_activities.user_id') // Join dengan tabel users
    //         ->where('user_activities.activity_type', 'login')
    //         ->whereNotExists(function ($subQuery) {
    //             $subQuery->select(DB::raw(1))
    //                 ->from('user_activities as ua')
    //                 ->whereColumn('ua.user_id', 'user_activities.user_id')
    //                 ->where('ua.activity_type', 'logout')
    //                 ->whereColumn('ua.created_at', '>', 'user_activities.created_at');
    //         })
    //         ->groupBy('user_activities.user_id', 'users.name', 'users.email'); // Group by kolom dari users juga
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function details()
    // {
    //     return $this->hasMany(UserActivityDetail::class, 'user_activity_id');
    // }


}
