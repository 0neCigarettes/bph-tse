<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkRole:1');
    }

    public function home()
    {
        $reports = Report::with(['tech'])
            ->where('user_id', auth()->user()->id)
            ->orderBy('report_status', 'asc')
            ->paginate(10);


        $data = [
            'reports' => $reports
        ];
        return view('user.index')->with($data);
    }

    public function addReport(Request $request)
    {
        Report::create([
            'user_id' => auth()->user()->id,
            'report_title' => $request->report_title
        ]);

        $data = [
            'status' => true,
            'error' => false,
            'message' => 'Berhasil membuat laporan'
        ];

        return redirect()->back()->with($data);
    }
}
