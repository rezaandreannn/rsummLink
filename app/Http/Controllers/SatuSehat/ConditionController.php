<?php

namespace App\Http\Controllers\SatuSehat;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\SatuSehat\Condition;
use App\Http\Controllers\Controller;

class ConditionController extends Controller
{
    public function index(Request $request)
    {
        // input 
        $created_at = $request->input('created_at');
        $status = $request->input('status');

        $date = $created_at ? date('Y-m-d', strtotime($created_at)) : Carbon::today()->toDateString();

        if ($status) {
            $status = $status;
        }

        // dd($status);

        $conditions = Condition::filterByDateAndStatus($date, $status);

        return view('satusehat.condition.index', compact('conditions'));
    }
}
