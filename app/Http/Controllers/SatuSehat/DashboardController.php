<?php

namespace App\Http\Controllers\SatuSehat;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SatuSehat\TransactionLog;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $app = $request->attributes->get('application');

        $today = Carbon::today()->toDateString();
        $defaultDaterange = "$today - $today";
        $daterange = $request->input('daterange', $defaultDaterange);

        [$startDate, $endDate] = explode(' - ', $daterange);

        $startDateFormatted = date('Y-m-d H:i:s', strtotime($startDate));
        $endDateFormatted = date('Y-m-d H:i:s', strtotime($endDate));

        $logs = TransactionLog::filterByDateRangeAndCountResources('2024-07-15 14:24:29', '2024-07-15 14:24:29');
        // dd($filteredLogs);
        $resources = [
            'Encounter',
            'Condition',
            'Observation'
        ];

        // $user = Auth::user();
        // $test = $user->roles($app->id)->where('name', 'admin')->exists();
        // dd($test);
        return view('satusehat.dashboard', compact('app', 'daterange', 'logs'));
    }

    public function log(Request $request)
    {

        $daterange = $request->input('daterange');
        // Memisahkan tanggal mulai dan tanggal akhir dari daterange
        [$startDate, $endDate] = explode(' - ', $daterange);

        // Memastikan tanggal dalam format yang benar
        $startDateFormatted = date('Y-m-d H:i:s', strtotime($startDate));
        $endDateFormatted = date('Y-m-d H:i:s', strtotime($endDate));

        $filteredLogs = TransactionLog::filterByDateRangeAndCountResources($startDateFormatted, $endDateFormatted);

        return view('satusehat.dashboard', [
            'logs' => $filteredLogs,
            'daterange' => $daterange
        ]);
    }
}
