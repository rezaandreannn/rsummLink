<?php

namespace App\Http\Controllers\SatuSehat\Master;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Simrs\RegisterPasien;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;
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

        return view('satusehat.master-data.pasien.index');
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
                    <th rowspan="2">No</th>
                    <th rowspan="2" class="align-center">No MR</th>
                    <th rowspan="2">NIK</th>
                    <th rowspan="2">ID Satu Sehat</th>
                    <th colspan="2" class="text-center">Nama Pasien</th>
            </tr>
            <tr>
                <th>RS</th>
                <th>SatuSehat</th>
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
                    <td>' . ($row->nama_pasien_rs ?? '') . '</td>
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
