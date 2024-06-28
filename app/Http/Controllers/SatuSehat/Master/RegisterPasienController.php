<?php

namespace App\Http\Controllers\SatuSehat\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Simrs\RegisterPasien;

class RegisterPasienController extends Controller
{
    public function index()
    {
        return view('satusehat.master-data.register.index');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {

            $data = RegisterPasien::where('No_MR', 'like', '%' . $request->search . '%')
                ->orwhere('Nama_Pasien', 'like', '%' . $request->search . '%')
                ->orwhere('HP2', 'like', '%' . $request->search . '%')
                ->take(10)
                ->get();

            $output = '';
            if (count($data) > 0) {

                $output = '
                <table id="table-1" class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>No</th>
                    <th>No MR</th>
                    <th>NIK</th>
                    <th>Nama Pasien</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
            </tr>
                </thead>
                <tbody>';
                $counter = 1;
                foreach ($data as $row) {
                    $output .= '
                    <tr>
                    <th style="width: 5%">' . $counter . '</th>
                    <td>' . ($row->No_MR ?? '') . '</td>
                    <td>' . ($row->HP2 ?? '') . '</td>
                    <td>' . ($row->Nama_Pasien ?? '') . '</td>
                    <td>' . ($row->Jenis_Kelamin ?? '') . '</td>
                    <td>' . ($row->Alamat ?? '') . '</td>
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
