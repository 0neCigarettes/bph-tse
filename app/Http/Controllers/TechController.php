<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class TechController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkRole:2');
    }

    public function home()
    {
        $reports = Report::with(['user'])
            ->orderBy('report_status', 'asc')
            ->where('tech_id', auth()->user()->id)
            ->paginate(10);
        $data = [
            'reports' => $reports
        ];

        return view('tech.index', $data);
    }

    public function solve(Request $request, $report_id)
    {
        $report = Report::find($report_id);
        $report->report_status = 2;
        $report->solving_description = $request->solving_description;
        $report->save();

        $data = [
            'status' => true,
            'error' => false,
            'message' => 'Berhasil menyelesaikan tugas'
        ];

        return redirect()->back()->with($data);
    }
}
