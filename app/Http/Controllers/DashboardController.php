<?php
namespace App\Http\Controllers;

use App\Models\Farm;
use App\Models\LivestockCount;
use App\Models\Prescription;
use App\Models\ServiceRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $registered_farms      = Farm::where('status', 'approved')->withoutTrashed()->count();
        $pending_farms         = Farm::where('status', 'pending')->withoutTrashed()->count();
        $service_records       = ServiceRecord::withoutTrashed()->count();
        $pending_prescriptions = Prescription::where('status', 'pending')->withoutTrashed()->count();

        $livestockCountByType = LivestockCount::selectRaw('livestock_type_id, SUM(total) as total')
            ->whereHas('farm', function ($query) {
                $query->where('status', '!=', 'pending')->whereNull('deleted_at');
            })
            ->with('livestockType:id,name')
            ->groupBy('livestock_type_id')
            ->get()
            ->map(function ($row) {
                return [
                    'type'  => $row->livestockType->name ?? 'Unknown',
                    'total' => (int) $row->total,
                ];
            });

        // ------------------
        $currentMonthDates  = [];
        $lastMonthDates     = [];
        $currentMonthCounts = [];
        $lastMonthCounts    = [];

        $today        = now();
        $currentMonth = $today->format('Y-m');
        $lastMonth    = $today->copy()->subMonth()->format('Y-m');

        $daysInCurrentMonth = $today->daysInMonth;
        $daysInLastMonth    = $today->copy()->subMonth()->daysInMonth;

        for ($day = 1; $day <= max($daysInCurrentMonth, $daysInLastMonth); $day++) {
            $dateCurrent = Carbon::parse("$currentMonth-" . str_pad($day, 2, '0', STR_PAD_LEFT))->toDateString();
            $dateLast    = Carbon::parse("$lastMonth-" . str_pad($day, 2, '0', STR_PAD_LEFT))->toDateString();

            $currentCount = ServiceRecord::whereDate('created_at', $dateCurrent)->count();
            $lastCount    = ServiceRecord::whereDate('created_at', $dateLast)->count();

            $currentMonthDates[]  = $day . ' তারিখ';
            $currentMonthCounts[] = $currentCount;
            $lastMonthCounts[]    = $lastCount;
        }
        // ------------------

        return view('dashboard.admin', compact('registered_farms', 'pending_farms', 'service_records', 'pending_prescriptions', 'livestockCountByType', 'currentMonthDates', 'currentMonthCounts', 'lastMonthCounts'));
    }
}
