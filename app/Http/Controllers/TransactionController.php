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
            $trips = Trip::with('user') // Pastikan relasi user() di model Trip
                ->where('status', 'completed')
                ->orderByDesc('created_at')
                ->get();

            $totalFare = $trips->sum('trip_fare');
            $totalTrip = $trips->count();

            return DataTables::of($trips)
                ->addIndexColumn()
                ->editColumn('created_at', fn($row) => $row->created_at->format('d-m-Y H:i'))
                ->addColumn('geton_short', function ($row) {
                    $parts = explode(',', $row->geton_location);
                    return trim(($parts[0] ?? '') . (isset($parts[1]) ? ', ' . $parts[1] : ''));
                })
                ->addColumn('getoff_short', function ($row) {
                    $parts = explode(',', $row->getoff_location);
                    return trim(($parts[0] ?? '') . (isset($parts[1]) ? ', ' . $parts[1] : ''));
                })
                ->editColumn('user_id', function ($row) {
                    return optional($row->user)->name ?? '-';
                })
                ->editColumn('license_plate', function ($row) {
                    return $row->license_plate ?? '-';
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
                ->with([
                    'summary' => [
                        'total_trip' => $totalTrip,
                        'total_fare' => $totalFare
                    ]
                ])
                ->toJson();
        }

        return view('dashboard.transactions.index', [
            'titlePages' => 'Laporan Perjalanan Angkot'
        ]);
    }
}
