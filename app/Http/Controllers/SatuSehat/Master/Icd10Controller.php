<?php

namespace App\Http\Controllers\SatuSehat\Master;

use Illuminate\Http\Request;
use App\Models\SatuSehat\Icd10;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class Icd10Controller extends Controller
{
    protected $icd10Model, $viewPath;

    public function __construct(Icd10 $icd10)
    {
        $this->icd10Model = $icd10;
        $this->viewPath = 'satusehat.master-data.icd10';
    }

    public function index()
    {
        $cacheKey = 'dataIcd10';
        if (Cache::has($cacheKey)) {
            $dataIcd10 = Cache::get($cacheKey);
        } else {
            $dataIcd10 = $this->icd10Model
                ->where('active', 1)
                ->get();

            // Simpan data ke cache
            Cache::put($cacheKey, $dataIcd10, now()->addMinutes(10));
        }

        return view($this->viewPath . '.index', compact('dataIcd10'));
    }
}
