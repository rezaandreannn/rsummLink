<?php

namespace App\Http\Controllers\SatuSehat;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SatuSehat\TransactionLog;
use App\Models\SatuSehat\Encounter\Encounter;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $daysOfWeek = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        // Array untuk hasil dengan nilai default 0
        $translatedDaysOfWeek = [
            'Senin' => 0,
            'Selasa' => 0,
            'Rabu' => 0,
            'Kamis' => 0,
            'Jumat' => 0,
            'Sabtu' => 0,
            'Minggu' => 0,
        ];

        // $daysOfWeek = [
        //     'Monday' => 0,
        //     'Tuesday' => 0,
        //     'Wednesday' => 0,
        //     'Thursday' => 0,
        //     'Friday' => 0,
        //     'Saturday' => 0,
        //     'Sunday' => 0,
        // ];

        // Ambil data encounter dari database
        $encounters = DB::table('satusehat_encounter')
            ->select(
                DB::raw("FORMAT(created_at, 'dddd') as day"),
                DB::raw('COUNT(*) as total_encounters')
            )
            // ->whereBetween('created_at', [
            //     Carbon::now()->startOfWeek()->format('Y-m-d H:i:s'),
            //     Carbon::now()->endOfWeek()->format('Y-m-d H:i:s')
            // ])
            ->whereBetween('created_at', ['2023-05-19 00:00:00', '2023-05-25 23:59:59'])
            ->groupBy(DB::raw("FORMAT(created_at, 'dddd')"), DB::raw('DATEPART(weekday, created_at)'))
            ->orderBy(DB::raw('DATEPART(weekday, created_at)'))
            ->get();

        foreach ($encounters as $encounter) {
            $translatedDay = $daysOfWeek[$encounter->day]; // Terjemahkan ke bahasa Indonesia
            $translatedDaysOfWeek[$translatedDay] = $encounter->total_encounters; // Update nilai total encounters
        }

        // Format data untuk chart atau keperluan lainnya
        $chartData = [
            'days' => array_keys($translatedDaysOfWeek),
            'totals' => array_values($translatedDaysOfWeek),
        ];

        // dd($chartData);

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
        return view('satusehat.dashboard', compact('app', 'daterange', 'logs', 'chartData'));
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
