<?php

namespace App\Models\SatuSehat;

use App\Models\Simrs\RegisterPasien;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pasien'; // Nama tabel default jika konfigurasi tidak ada
    protected $guarded = [];
    /**
     * Create a new model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Cek jika konfigurasi prefix_db ada, maka gunakan dalam pembentukan nama tabel
        if (config()->has('satusehatintegration.prefix_db')) {
            $this->table = config('satusehatintegration.prefix_db') . 'pasien';
        }
    }

    public function registerPasien()
    {
        return $this->hasOne(RegisterPasien::class, 'No_MR', 'no_mr');
    }
}
