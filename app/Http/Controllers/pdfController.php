<?php

namespace App\Http\Controllers;

use App\Models\FormingWHRecordmst;
use App\Models\Inspectionmst;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


class pdfController extends Controller
{

    public function index()
    {
        return view('index');

    }

 

    public function showChart(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $qc_dept_code = $request->input('qc_dept_code'); // Lấy qc_dept_code từ request
        $days = [];
        $currentDate = $fromDate;
        $allDataByDayAndDept = []; // Mảng phân loại dữ liệu theo 'day' và 'qc_dept_code'

        while ($currentDate <= $toDate) {
            $days[] = $currentDate;
            $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        }

        // Lặp qua các ngày
        foreach ($days as $day) {
            $data = DB::table('ta_inspectionmst')
                ->where('cofactory_code', 'GL4')
                ->whereDate('qip_date', $day)
                ->where('qc_dept_code', $qc_dept_code) // Lọc dữ liệu theo qc_dept_code
                ->get();

            // Kiểm tra xem có dữ liệu cho ngày và qc_dept_code này hay không
            if ($data->count() > 0) {
                $allDataByDayAndDept[$day] = $data;
            }
        }
        // dd($allDataByDayAndDept);
        return view('show', compact('allDataByDayAndDept'));
    }






}
