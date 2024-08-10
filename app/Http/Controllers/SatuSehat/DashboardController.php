<?php

namespace App\Http\Controllers\SatuSehat;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SatuSehat\Condition;
use App\Models\SatuSehat\TransactionLog;
use App\Models\SatuSehat\Encounter\Encounter;
use App\Models\SatuSehat\Observation;
use App\Models\ScheduleLog;

class DashboardController extends Controller
{
    // public function index(Request $request)
    // {
    //     $daysOfWeek = [
    //         'Monday' => 'Senin',
    //         'Tuesday' => 'Selasa',
    //         'Wednesday' => 'Rabu',
    //         'Thursday' => 'Kamis',
    //         'Friday' => 'Jumat',
    //         'Saturday' => 'Sabtu',
    //         'Sunday' => 'Minggu',
    //     ];

    //     // Array untuk hasil dengan nilai default 0
    //     $translatedDaysOfWeek = [
    //         'Senin' => 0,
    //         'Selasa' => 0,
    //         'Rabu' => 0,
    //         'Kamis' => 0,
    //         'Jumat' => 0,
    //         'Sabtu' => 0,
    //         'Minggu' => 0,
    //     ];


    //     // Ambil data encounter dari database
    //     $encounters = DB::table('satusehat_encounter')
    //         ->select(
    //             DB::raw("FORMAT(created_at, 'dddd') as day"),
    //             DB::raw('COUNT(*) as total_encounters')
    //         )
    //         // ->whereBetween('created_at', [
    //         //     Carbon::now()->startOfWeek()->format('Y-m-d H:i:s'),
    //         //     Carbon::now()->endOfWeek()->format('Y-m-d H:i:s')
    //         // ])
    //         ->whereBetween('created_at', ['2023-05-16 00:00:00', '2023-05-22 23:59:59'])
    //         ->groupBy(DB::raw("FORMAT(created_at, 'dddd')"), DB::raw('DATEPART(weekday, created_at)'))
    //         ->orderBy(DB::raw('DATEPART(weekday, created_at)'))
    //         ->get();

    //     foreach ($encounters as $encounter) {
    //         $translatedDay = $daysOfWeek[$encounter->day]; // Terjemahkan ke bahasa Indonesia
    //         $translatedDaysOfWeek[$translatedDay] = $encounter->total_encounters; // Update nilai total encounters
    //     }

    //     // Format data untuk chart atau keperluan lainnya
    //     $chartData = [
    //         'days' => array_keys($translatedDaysOfWeek),
    //         'totals' => array_values($translatedDaysOfWeek),
    //     ];

    //     // total finished per week
    //     // definisikan status
    //     $statusEncounter = [
    //         'arrived' => 0,
    //         'finished' => 0
    //     ];

    //     // Encounter
    //     $statuses = DB::table('satusehat_encounter')
    //         ->select(
    //             DB::raw("status as status"),
    //             DB::raw('COUNT(*) as total_encounters')
    //         )
    //         ->whereBetween('created_at', [
    //             Carbon::now()->startOfWeek()->format('Y-m-d H:i:s'),
    //             Carbon::now()->endOfWeek()->format('Y-m-d H:i:s')
    //         ])
    //         // ->whereBetween('created_at', ['2023-05-19 00:00:00', '2023-05-25 23:59:59'])
    //         ->groupBy('status')
    //         ->get();

    //     $totalEncounterPerWeek = $statuses->count();


    //     $totalEncounters = 0;
    //     foreach ($statuses as $status) {
    //         $totalEncounters += $status->total_encounters;

    //         if ($status->status == '') {
    //             $statusEncounter['arrived'] = $status->total_encounters;
    //         } elseif ($status->status == 'finished') {
    //             $statusEncounter['finished'] = $status->total_encounters;
    //         }
    //     }

    //     $finishedPercentage = $totalEncounters > 0 ? ($statusEncounter['finished'] / $totalEncounters) * 100 : 0;
    //     $persencentageEncounter = number_format($finishedPercentage, 2);

    //     // Encounter
    //     $totalEncounter = Encounter::count();
    //     $lastUpdatedEncounter = Encounter::latest('created_at')->value('created_at');

    //     // condition
    //     $totalCondition = Condition::where('status', 1)->count();
    //     $lastUpdatedCondition = Condition::where('status', 1)->latest('created_at')->value('created_at');

    //     // observation
    //     $totalObservation = Observation::count();
    //     $lastUpdatedObservation = Observation::latest('created_at')->value('created_at');

    //     // data schedule run
    //     $scheduleLogs = ScheduleLog::all();

    //     foreach ($scheduleLogs as $log) {
    //         $log->last_run_at = Carbon::parse($log->last_run_at);
    //     }

    //     // condition
    //     $conditionPerWeeks = DB::table('satusehat_condition')
    //         ->select(
    //             DB::raw("FORMAT(created_at, 'dddd') as day"),
    //             DB::raw('COUNT(*) as total_condition')
    //         )
    //         // ->whereBetween('created_at', [
    //         //     Carbon::now()->startOfWeek()->format('Y-m-d H:i:s'),
    //         //     Carbon::now()->endOfWeek()->format('Y-m-d H:i:s')
    //         // ])
    //         ->whereBetween('created_at', ['2023-05-16 00:00:00', '2023-05-25 23:59:59'])
    //         ->where('status', 1)
    //         ->groupBy(DB::raw("FORMAT(created_at, 'dddd')"), DB::raw('DATEPART(weekday, created_at)'))
    //         ->orderBy(DB::raw('DATEPART(weekday, created_at)'))
    //         ->get();

    //     foreach ($conditionPerWeeks as $condition) {
    //         $translatedDay = $daysOfWeek[$condition->day]; // Terjemahkan ke bahasa Indonesia
    //         $translatedDaysOfWeek[$translatedDay] = $condition->total_condition; // Update nilai total encounters
    //     }

    //     // Format data untuk chart atau keperluan lainnya
    //     $chartDataConditions = [
    //         'days' => array_keys($translatedDaysOfWeek),
    //         'totals' => array_values($translatedDaysOfWeek),
    //     ];


    //     // dd($chartDataConditions);



    //     return view('satusehat.dashboard', compact('chartData', 'statusEncounter', 'persencentageEncounter', 'totalEncounter', 'lastUpdatedEncounter', 'totalCondition', 'lastUpdatedCondition', 'totalObservation', 'lastUpdatedObservation', 'scheduleLogs', 'totalEncounterPerWeek', 'chartDataConditions', 'conditionPerWeeks'));
    // }

    public function index(Request $request)
    {

        $selectedMonth = $request->input('month', Carbon::now()->month);

        // deklarasi status
        $statusEncounter = [
            'arrived' => 0,
            'finished' => 0
        ];

        // query by month encounter
        $queryPerMonth = DB::table('satusehat_encounter')
            ->select('status', DB::raw('COUNT(*) as total_encounters'))
            ->whereMonth('created_at',  $selectedMonth)
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('status')
            ->get();

        // ambil get per month
        $totalEncounters = $queryPerMonth->sum('total_encounters');

        foreach ($queryPerMonth as $encounterPerMonth) {
            if ($encounterPerMonth->status == '') {
                $statusEncounter['arrived'] = $encounterPerMonth->total_encounters;
            } elseif ($encounterPerMonth->status == 'finished') {
                $statusEncounter['finished'] = $encounterPerMonth->total_encounters;
            }
        }

        $finishedPercentage = $totalEncounters > 0 ? ($statusEncounter['finished'] / $totalEncounters) * 100 : 0;
        // hasil persentase per month
        $persencentageEncounter = number_format($finishedPercentage, 2);


        $daysOfWeek = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        // Default hasil encounter dan condition by day
        $translatedDaysOfWeekEncounter = [
            'Senin' => 0,
            'Selasa' => 0,
            'Rabu' => 0,
            'Kamis' => 0,
            'Jumat' => 0,
            'Sabtu' => 0,
            'Minggu' => 0,
        ];

        $translatedDaysOfWeekCondition = $translatedDaysOfWeekEncounter;

        // Ambil data encounter dari database
        $encounters = DB::table('satusehat_encounter')
            ->select(
                DB::raw("FORMAT(created_at, 'dddd') as day"),
                DB::raw('COUNT(*) as total_encounters')
            )
            ->whereBetween('created_at', [
                Carbon::now()->startOfWeek()->format('Y-m-d H:i:s'),
                Carbon::now()->endOfWeek()->format('Y-m-d H:i:s')
            ])
            // ->whereBetween('created_at', ['2023-05-16 00:00:00', '2023-05-22 23:59:59'])
            ->groupBy(DB::raw("FORMAT(created_at, 'dddd')"), DB::raw('DATEPART(weekday, created_at)'))
            ->orderBy(DB::raw('DATEPART(weekday, created_at)'))
            ->get();

        foreach ($encounters as $encounter) {
            $translatedDay = $daysOfWeek[$encounter->day];
            $translatedDaysOfWeekEncounter[$translatedDay] = $encounter->total_encounters;
        }

        // Format data untuk chart encounter
        $chartDataEncounter = [
            'days' => array_keys($translatedDaysOfWeekEncounter),
            'totals' => array_values($translatedDaysOfWeekEncounter),
        ];

        // Ambil data condition dari database
        $conditions = DB::table('satusehat_condition')
            ->select(
                DB::raw("FORMAT(created_at, 'dddd') as day"),
                DB::raw('COUNT(*) as total_condition')
            )
            ->whereBetween('created_at', [
                Carbon::now()->startOfWeek()->format('Y-m-d H:i:s'),
                Carbon::now()->endOfWeek()->format('Y-m-d H:i:s')
            ])
            // ->whereBetween('created_at', ['2023-05-16 00:00:00', '2023-05-25 23:59:59'])
            ->where('status', 1)
            ->groupBy(DB::raw("FORMAT(created_at, 'dddd')"), DB::raw('DATEPART(weekday, created_at)'))
            ->orderBy(DB::raw('DATEPART(weekday, created_at)'))
            ->get();

        foreach ($conditions as $condition) {
            $translatedDay = $daysOfWeek[$condition->day];
            $translatedDaysOfWeekCondition[$translatedDay] = $condition->total_condition;
        }

        // Format data untuk chart condition
        $chartDataCondition = [
            'days' => array_keys($translatedDaysOfWeekCondition),
            'totals' => array_values($translatedDaysOfWeekCondition),
        ];

        // Total encounters and conditions for the week
        $totalEncounterPerWeek = $encounters->sum('total_encounters');
        $totalConditionPerWeek = $conditions->sum('total_condition');

        // deklarasi status per week
        $statusEncounterPerWeek = [
            'arrived' => 0,
            'finished' => 0
        ];

        // query by status per week
        $statusesEncounterPerWeeks = DB::table('satusehat_encounter')
            ->select('status', DB::raw('COUNT(*) as total_encounters'))
            ->whereBetween('created_at', [
                Carbon::now()->startOfWeek()->format('Y-m-d H:i:s'),
                Carbon::now()->endOfWeek()->format('Y-m-d H:i:s')
            ])
            ->groupBy('status')
            ->get();

        $totalEncounterPerWeek = $statusesEncounterPerWeeks->sum('total_encounters');

        foreach ($statusesEncounterPerWeeks as $encounterPerWeek) {
            if ($encounterPerWeek->status == '') {
                $statusEncounterPerWeek['arrived'] = $encounterPerWeek->total_encounters;
            } elseif ($encounterPerWeek->status == 'finished') {
                $statusEncounterPerWeek['finished'] = $encounterPerWeek->total_encounters;
            }
        }

        $finishedPercentageWeek = $totalEncounterPerWeek > 0 ? ($statusEncounterPerWeek['finished'] / $totalEncounterPerWeek) * 100 : 0;
        $persencentageEncounterPerWeek = number_format($finishedPercentageWeek, 2);

        // Encounter
        $totalEncounter = Encounter::count();
        $lastUpdatedEncounter = Encounter::latest('created_at')->value('created_at');

        // Condition
        $totalCondition = Condition::where('status', 1)->count();
        $lastUpdatedCondition = Condition::where('status', 1)->latest('created_at')->value('created_at');

        // Observation
        $totalObservation = Observation::count();
        $lastUpdatedObservation = Observation::latest('created_at')->value('created_at');

        // Data schedule run
        $scheduleLogs = ScheduleLog::all();

        foreach ($scheduleLogs as $log) {
            $log->last_run_at = Carbon::parse($log->last_run_at);
        }

        return view('satusehat.dashboard', compact(
            'chartDataEncounter',
            'chartDataCondition',
            'statusEncounter',
            'statusEncounterPerWeek',
            'persencentageEncounter',
            'persencentageEncounterPerWeek',
            'totalEncounter',
            'lastUpdatedEncounter',
            'totalCondition',
            'lastUpdatedCondition',
            'totalObservation',
            'lastUpdatedObservation',
            'scheduleLogs',
            'totalEncounterPerWeek',
            'totalConditionPerWeek',
            'totalEncounters'
        ));
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
