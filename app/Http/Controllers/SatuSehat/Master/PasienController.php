<?php

namespace App\Http\Controllers\SatuSehat\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SatuSehat\Pasien;
use App\Services\SatuSehat\RegisterPasienService;

class PasienController extends Controller
{
    protected $registerPasienService;

    public function __construct(RegisterPasienService $registerPasienService)
    {
        $this->registerPasienService = $registerPasienService;
    }

    public function index(Request $request)
    {

        // $format = '000000';
        // $latestData = RegisterPasien::latest('No_MR')->first();
        // $latestNo_MR = $latestData->No_MR;
        // $rangeSize = 2000;
        // $totalRanges = ceil(intval($latestNo_MR) / $rangeSize);
        // $totalRanges = intval($totalRanges);

        // $data = [];

        // for ($i = 0; $i < $totalRanges; $i++) {
        //     $start = $i * $rangeSize;
        //     $end = ($i + 1) * $rangeSize - 1;

        //     $startFormatted = str_pad($start, strlen($format), '0', STR_PAD_LEFT);
        //     $endFormatted = str_pad($end, strlen($format), '0', STR_PAD_LEFT);

        //     $data[] = [
        //         'id' => $i + 1,
        //         'start' => $startFormatted,
        //         'end' => $endFormatted
        //     ];
        // }

        // $selectedRange = $request->get('range_id', 1);
        // $selectedRangeData = $data[$selectedRange - 1];

        // $registerPasiens = $this->registerPasienService->getDataByRange($selectedRangeData);

        $pasiens = Pasien::all();
        return view('satusehat.master-data.pasien.index', compact('pasiens'));
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {

            $data = $this->registerPasienService->keyup($request->search);

            $output = '';
            if (count($data) > 0) {

                $output = '
                <table id="table-1" class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>No</th>
                    <th class="align-center">No MR</th>
                    <th>NIK</th>
                    <th>ID Satu Sehat</th>
                    <th>Nama Pasien</th>
            </tr>
                </thead>
                <tbody>';
                $counter = 1;
                foreach ($data as $row) {
                    $output .= '
                    <tr>
                    <th style="width: 5%">' . $counter . '</th>
                    <td>' . ($row->no_mr ?? '') . '</td>
                    <td>' . ($row->nik ?? '') . '</td>
                    <td>' . ($row->id_pasien ?? '') . '</td>
                    <td>' . ($row->nama_pasien ?? '') . '</td>
                    </tr>
                        ';
                    $counter++;
                }
                $output .= '
                 </tbody>
                </table>';
            } else {
                $output .= 'No results';
            }

            return $output;
        }
    }
}
