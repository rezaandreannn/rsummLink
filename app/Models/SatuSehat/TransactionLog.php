<?php

namespace App\Models\SatuSehat;


use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionLog extends Model
{
    use HasFactory;

    protected $table = 'satusehat_transaction_logs';
    protected $guarded = [];

    // Metode untuk memfilter berdasarkan resource
    public static function filterByResource($resource, $date, $status = NULL)
    {
        $query = self::where('resource', $resource)
            ->whereDate('created_at', $date);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->get();
    }

    public static function filterByResourceAndDateRange($resource, $startDate, $endDate)
    {
        return self::where('resource', $resource)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
    }

    public static function filterByDateRange($startDate, $endDate)
    {
        $resources = [
            'Encounter',
            'Condition',
            'Observation'
        ];

        return self::whereBetween('created_at', [$startDate, $endDate])
            ->get();
    }

    public static function filterByDateRangeAndCountResources($startDate, $endDate)
    {
        $resources = Config::get('resources.resources');

        $counts = self::select('resource', \DB::raw('count(*) as total'))
            ->whereIn('resource', $resources)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('resource')
            ->pluck('total', 'resource');

        // Inisialisasi array hasil dengan semua resource diisi 0
        $results = array_fill_keys($resources, 0);

        // Gabungkan hasil query dengan array default
        foreach ($counts as $resource => $total) {
            $results[$resource] = $total;
        }

        return $results;
    }
}
