<?php

namespace App\Http\Controllers\SatuSehat\Encounter;

use App\Http\Controllers\Controller;
use App\Models\SatuSehat\TransactionLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogTransactionController extends Controller
{
    protected $resource;

    public function __construct()
    {
        $this->resource = 'Encounter';
    }

    public function index(Request $request)
    {
        $created_at = $request->input('created_at');
        $status = $request->input('status');
        // Atur default tanggal ke hari ini jika tidak ada input created_at
        $date = $created_at ? date('Y-m-d', strtotime($created_at)) : Carbon::today()->toDateString();

        // Konversi status ke kode status yang sesuai
        if ($status) {
            $status = $status == 'sukses' ? '201' : '400';
        }

        $logTransactions = TransactionLog::filterByResource($this->resource, $date, $status);

        return view('satusehat.encounter.log.index', compact('logTransactions'));
    }
}
