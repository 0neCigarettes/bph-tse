<?php

namespace App\Http\Controllers;

use App\Imports\DataImport;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Excel;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkRole:0');
    }

    public function home()
    {
        $reports = Report::with(['tech', 'user'])
            ->orderBy('report_status', 'asc')
            ->paginate(10);


        $tech_ids = Report::where('report_status', 1)->pluck('tech_id');

        $techs = User::where('role', 2)->where('status', 0);

        if ($tech_ids != null || count($tech_ids) > 0) {
            $techs->whereNotIn('id', $tech_ids);
        }

        $techs = $techs->get();


        $data = [
            'reports' => $reports,
            'techs' => $techs
        ];

        return view('admin.index', $data);
    }

    public function assignTech(Request $request, $report_id)
    {
        $report = Report::find($report_id);
        $report->tech_id = $request->tech_id;
        $report->report_status = 1;
        $report->save();

        $data = [
            'status' => true,
            'message' => 'Berhasil menugaskan teknisi'
        ];

        return redirect()->back()->with($data);
    }

    public function allUsers(Request $request)
    {

        $roles = [
            0 => [
                'id' => 1,
                'label' => 'User',
            ],
            1 => [
                'id' => 2,
                'label' => 'Teknisi',
            ],
        ];


        $users = User::where('role', '!=', 0);

        if ($request->name) {
            $users->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->role && $request->role != 'all') {
            $users->where('role', $request->role);
        }

        $users = $users->paginate(10);

        $data = [
            'users' => $users,
            'query' => $request->query(),
            'roles' => $roles
        ];

        return view('admin.users', $data);
    }

    public function uploadReportExcel(Request $request)
    {
        $validRequest = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls'
        ]);

        if ($validRequest->fails()) {
            $data = [
                'status' => true,
                'error' => true,
                'message' => 'File harus ber extensi .xlsx'
            ];
            return redirect()->back()->with($data);
        }

        $theArray = Excel::toArray(new DataImport, $request->file('file'));
        $datas = $theArray[0];
        foreach ($datas as $data) {
            $user = User::where('phone', $data['no_hp_pelapor'])->first();
            $tech = User::where('phone', $data['no_hp_teknisi'])->first();
            $report = new Report();
            $report->user_id = $user->id;
            $report->tech_id = $tech->id;
            $report->report_title = $data['judul'];
            $report->solving_description = $data['solusi'];
            $report->report_status = 2;
            $report->created_at = $data['tanggal'];
            $report->save();
        }

        $data = [
            'status' => true,
            'error' => false,
            'message' => 'Berhasil mengupload data'
        ];
        return redirect()->back()->with($data);
    }

    public function deleteUser($user_id)
    {
        $delete = User::whwre('id', $user_id)->delete();

        if ($delete) {
            $data = [
                'status' => true,
                'error' => false,
                'message' => 'Berhasil menghapus user'
            ];
        } else {
            $data = [
                'status' => true,
                'error' => true,
                'message' => 'Gagal menghapus user'
            ];
        }

        return redirect()->back()->with($data);
    }

    public function downloadTemplate()
    {
        $path = public_path('templates/template-upload.xlsx');
        return response()->download($path);
    }
}
