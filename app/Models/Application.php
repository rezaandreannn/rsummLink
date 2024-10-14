<?php

namespace App\Models;

use App\Models\Permission;
use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'image', 'prefix', 'status', 'description'])
            ->logOnlyDirty();
    }

    public function roles()
    {
        return $this->hasMany(Role::class, 'application_id');
    }

    public function menus()
    {
        return $this->hasMany(Menu::class, 'application_id');
    }


    public function permissions()
    {
        return $this->hasMany(Permission::class, 'application_id');
    }
}
