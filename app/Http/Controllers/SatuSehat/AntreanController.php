<?php

namespace App\Http\Controllers\SatuSehat;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AntreanController extends Controller
{
    public function index()
    {
        $results =  DB::table('DB_RSMM.dbo.ANTRIAN as a')
            ->leftJoin('DB_RSMM.dbo.REGISTER_PASIEN as rp', 'a.No_MR', '=', 'rp.No_MR')
            ->leftJoin('DB_RSMM.dbo.PENDAFTARAN as p', 'p.No_MR', '=', 'a.No_MR')
            ->leftJoin('PKU.dbo.TAC_RJ_STATUS as trs', 'trs.FS_KD_REG', '=', 'p.No_Reg')
            ->where('a.Tanggal', '2024-06-13')
            ->where('a.Dokter', '140')
            ->where('p.Tanggal', '2024-06-13')
            ->where('p.Kode_Dokter', '140')
            ->where('trs.FS_STATUS', '!=', 0)
            ->whereNotNull('rp.HP2')
            ->where('rp.HP2', '!=', '')
            ->select(
                'a.Nomor as no_antrian',
                'p.No_Reg as no_reg',
                'a.No_MR as no_mr',
                'p.Kode_Dokter as kode_dokter',
                'rp.Nama_Pasien as nama_pasien',
                'rp.HP2 as nik'
            )
            ->orderBy('a.Nomor')
            ->get();

        dd($results);
    }
}
