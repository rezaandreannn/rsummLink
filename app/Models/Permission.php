<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function menus()
    {
        return $this->hasMany(Menu::class, 'permission_id');
    }

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class, 'permission_id');
    }

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }
}
