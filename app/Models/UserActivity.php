<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserActivity extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'activity_type', 'model_type', 'model_id', 'changes'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeByAuthId($query)
    {
        $today = now();
        return $query->where('user_id', Auth::id())
            ->whereDate('created_at', $today);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function getDescription()
    {
        // Jika changes sudah berupa array, tidak perlu decode lagi
        $data = is_array($this->changes) ? $this->changes : json_decode($this->changes, true);

        switch ($this->activity_type) { // Gunakan activity_type
            case 'created':
                return sprintf(
                    'Membuat %s baru dengan ID %d. Data: %s',
                    class_basename($this->model_type),
                    $this->model_id,
                    json_encode($data, JSON_PRETTY_PRINT)
                );

            case 'updated':
                return sprintf(
                    'Memperbarui %s dengan ID %d. Bidang yang diubah: %s',
                    class_basename($this->model_type),
                    $this->model_id,
                    $this->getUpdatedFields()
                );

            case 'deleted':
                return sprintf(
                    'Menghapus %s dengan ID %d.',
                    class_basename($this->model_type),
                    $this->model_id
                );

            default:
                return 'Unknown action';
        }
    }


    private function getUpdatedFields()
    {
        // Sama seperti di atas, cek apakah data sudah berupa array
        $data = is_array($this->changes) ? $this->changes : json_decode($this->changes, true);
        $changes = [];

        // Buang updated_at dan created_at jika ada
        if (isset($data['updated_at'])) {
            unset($data['updated_at']);
        }
        if (isset($data['created_at'])) {
            unset($data['created_at']);
        }

        // Iterasi perubahan
        foreach ($data as $key => $value) {
            $changes[] = sprintf('%s: %s', $key, $value);
        }

        return implode(', ', $changes);
    }
}
