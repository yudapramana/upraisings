<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Trip;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionController extends Controller
{
    // public function index()
    // {
    //      return view('dashboard.transactions.index', [
    //         'titlePages' => 'Laporan Transaksi',
    //     ]);
    // }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Trip::with('user') // Pastikan relasi user() di model Trip
                ->where('status', 'completed');
                // ->orderByDesc('created_at')



            if ($request->filled('month_year')) {
                try {
                    [$year, $month] = explode('-', $request->month_year);
                    $query->whereYear('created_at', $year)
                        ->whereMonth('created_at', $month);
                } catch (\Exception $e) {
                    // Optional: handle format error
                }
            }

            $trips = $query->latest()->get();

            $totalFare = $trips->sum('trip_fare');
            $totalTrip = $trips->count();

            return DataTables::of($trips)
                ->addIndexColumn()
                ->editColumn('created_at', fn($row) => $row->created_at->format('d-m-Y H:i'))
                ->addColumn('route', function ($row) {
                    $getonParts = explode(',', $row->geton_location);
                    $getoffParts = explode(',', $row->getoff_location);

                    $geton = trim(($getonParts[0] ?? '') . (isset($getonParts[1]) ? ', ' . $getonParts[1] : ''));
                    $getoff = trim(($getoffParts[0] ?? '') . (isset($getoffParts[1]) ? ', ' . $getoffParts[1] : ''));

                    // return $geton . ' →Ke  ' . $getoff;
                    return '<b>Naik</b> ' . $geton . ' -- <b>Turun</b> ' . $getoff;
                })
                ->editColumn('user_id', function ($row) {
                    return optional($row->user)->name ?? '-';
                })
                ->editColumn('license_plate', function ($row) {
                    return '<span class="badge badge-dark">' .$row->license_plate . '</span>' ?? '-';
                })
                ->editColumn('pickup_time', function ($row) {
                    return $row->pickup_time ? $row->pickup_time->format('d-m-Y H:i') : '-';
                })
                ->editColumn('arrival_time', function ($row) {
                    return $row->arrival_time ? $row->arrival_time->format('d-m-Y H:i') : '-';
                })
                ->editColumn('trip_fare', function ($row) {
                    return number_format($row->trip_fare ?? 0, 2, ',', '.');
                })
                ->addColumn('route_number', function ($row) {
                    return "<strong>{$row->route_number}</strong> ({$row->route_name})";
                    // return ($row->route_number ?? '-') . ' - ' . ($row->route_name ?? '-');
                })
                ->with([
                    'summary' => [
                        'total_trip' => $totalTrip,
                        'total_fare' => $totalFare
                    ]
                ])
                ->rawColumns(['route', 'license_plate', 'route_number'])
                ->toJson();
        }

        return view('dashboard.transactions.index', [
            'titlePages' => 'Laporan Perjalanan Angkot'
        ]);
    }
}
