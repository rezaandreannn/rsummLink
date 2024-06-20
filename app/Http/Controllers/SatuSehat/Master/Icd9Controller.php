<?php

namespace App\Http\Controllers\SatuSehat\Master;

use App\Http\Controllers\Controller;
use App\Models\SatuSehat\Icd9;
use Illuminate\Http\Request;

class Icd9Controller extends Controller
{
    protected $icd9Model, $viewPath;

    public function __construct(Icd9 $icd9)
    {
        $this->icd9Model = $icd9;
        $this->viewPath = 'satusehat.master-data.icd9cm';
    }

    public function index()
    {

        $icd9cm = $this->icd9Model
            ->where('active', 1)
            ->get();

        return view($this->viewPath . '.index', compact('icd9cm'));
    }
}
