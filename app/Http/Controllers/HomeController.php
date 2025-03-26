<?php

namespace App\Http\Controllers;

use DB;

use App\Models\SubmissionList;

use Illuminate\Http\Request;

class HomeController extends Controller {

    public function index(){
        return view('landing.main', [
            'title' => 'Angkot App'
        ]);
    }
    // public function index() {
    //     $datas =  DB::table('submission_lists as a')
    //     ->select(
    //         'a.id as id',
    //         'a.submission_name as name',
    //         'a.reason as reason',
    //         'b.name as name_vechile',
    //         'b.number_vechile as number_vechile',
    //         'b.fuel as fuel_vechile',
    //         'a.status as status',
    //         'a.note as note',
    //         'a.start_date as start_date',
    //         'a.end_date as end_date',
    //         'c.name as approve_by',
    //         'a.created_at as created_at',
    //         'a.updated_at as updated_at',
    //     )
    //     ->leftjoin('vehicle_lists as b', 'b.id', '=', 'a.vehicle_id')
    //     ->leftjoin('users as c', 'c.id', '=', 'a.approve_by')
    //     ->get();

    //     $params = [
    //         "titlePages"    => 'Pengajuan Kendarran',
    //         "cars"          => DB::table('vehicle_lists')->get(),
    //         "datas"         => $datas,
    //     ];

    //     return view('index', $params);
    // }
    
    // public function store(Request $request) {
    //     $dateArray = explode(" ", $request->rangeDate);

    //     SubmissionList::create([
    //         'submission_name'   => $request->submission_name,
    //         'vehicle_id'        => $request->vehicle_id,
    //         'reason'            => $request->reason,
    //         'note'              => $request->note,
    //         'status'            => 'waiting',
    //         'start_date'        => date_format(date_create($dateArray[0]), 'Y-m-d'),
    //         'end_date'          => date_format(date_create($dateArray[2]), 'Y-m-d'),
    //         'created_at'        => date('Y-m-d H:i:s'),
    //         'updated_at'        => date('Y-m-d H:i:s'),
    //     ]);

    //     return redirect()->back();
    // }

    // public function destroy(Request $request) {
    //     User::find($request->id)->delete();
    //     return response()->json(array('success' => true));
    // }
}
