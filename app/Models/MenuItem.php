<?php

namespace App\Models;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItem extends Model
{
    use HasFactory;
    protected $table = 'menu_items';
    protected $guarded = [];

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
