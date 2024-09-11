<?php

namespace App\Models;

use App\Models\UserActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($menu) {
            UserActivity::create([
                'user_id' => Auth::id(),
                'activity_type' => 'created',
                'model_type' => get_class($menu),
                'model_id' => $menu->id,
                'changes' => json_encode($menu->getAttributes()),
            ]);
        });

        static::updated(function ($post) {
            UserActivity::create([
                'user_id' => Auth::id(),
                'activity_type' => 'updated',
                'model_type' => get_class($post),
                'model_id' => $post->id,
                'changes' => json_encode($post->getChanges()),
            ]);
        });

        static::deleted(function ($post) {
            UserActivity::create([
                'user_id' => Auth::id(),
                'activity_type' => 'deleted',
                'model_type' => get_class($post),
                'model_id' => $post->id,
                'changes' => json_encode($post->getAttributes()),
            ]);
        });
    }

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
