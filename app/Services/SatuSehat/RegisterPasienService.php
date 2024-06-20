<?php

namespace App\Services\SatuSehat;

use App\Models\Simrs\RegisterPasien;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class RegisterPasienService
{
    public function getDataByRange($selectedRangeData)
    {

        $cacheKey = 'merged_data_range_' . $selectedRangeData['id'];

        // Cek apakah data sudah ada di cache file
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // Ambil data dari REGISTER_PASIEN di koneksi db_rsumm
        $registerPasiens = RegisterPasien::whereBetween('No_MR', [$selectedRangeData['start'], $selectedRangeData['end']])
            ->select('No_MR', 'Nama_Pasien', 'HP2')
            ->get();

        $noMRs = $registerPasiens->pluck('No_MR');

        // Ambil data dari satusehat_pasien di koneksi default
        $satusehatPasiens = DB::table('satusehat_pasien as sp')
            ->whereIn('sp.no_mr', $noMRs)
            ->select('sp.no_mr', 'sp.id_pasien', 'sp.nama_pasien')
            ->get();

        // Gabungkan data berdasarkan No_MR
        $mergedData = $registerPasiens->map(function ($registerPasien) use ($satusehatPasiens) {
            $satusehatPasien = $satusehatPasiens->firstWhere('no_mr', $registerPasien->No_MR);

            return (object) [
                'no_mr' => $registerPasien->No_MR,
                'nik' => $registerPasien->HP2 ?? '',
                'nama_pasien_rs' => $registerPasien->Nama_Pasien ?? '',
                'id_pasien' => $satusehatPasien->id_pasien ?? null,
                'nama_pasien' => $satusehatPasien->nama_pasien ?? null,
            ];
        });

        // Simpan data ke cache file
        Cache::put($cacheKey, $mergedData, now()->addMinutes(10)); // Simpan selama 10 menit

        return $mergedData;
    }

    public function keyup($search)
    {
        $registerPasiens = RegisterPasien::where('No_MR', 'like', '%' . $search . '%')
            ->orwhere('Nama_Pasien', 'like', '%' . $search . '%')
            ->orwhere('HP2', 'like', '%' . $search . '%')
            ->take(10)
            ->select('No_MR', 'Nama_Pasien', 'HP2')
            ->get();

        $noMRs = $registerPasiens->pluck('No_MR');

        // Ambil data dari satusehat_pasien di koneksi default
        $satusehatPasiens = DB::table('satusehat_pasien as sp')
            ->whereIn('sp.no_mr', $noMRs)
            ->select('sp.no_mr', 'sp.id_pasien', 'sp.nama_pasien')
            ->get();

        // Gabungkan data berdasarkan No_MR
        $mergedData = $registerPasiens->map(function ($registerPasien) use ($satusehatPasiens) {
            $satusehatPasien = $satusehatPasiens->firstWhere('no_mr', $registerPasien->No_MR);

            return (object) [
                'no_mr' => $registerPasien->No_MR,
                'nik' => $registerPasien->HP2 ?? '',
                'nama_pasien_rs' => $registerPasien->Nama_Pasien ?? '',
                'id_pasien' => $satusehatPasien->id_pasien ?? null,
                'nama_pasien' => $satusehatPasien->nama_pasien ?? null,
            ];
        });

        return $mergedData;
    }
}
