<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Models\activeReports;
use App\Models\Programs;
use App\Models\Report;
use App\Models\User;
use Inertia\Inertia;
Use Auth;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index() {
        $reportCount = [];
        $reportArr = [];

        $activeReports = Auth::user()->activeReports->load('program');

        $submittedReports = DB::table('reports')
        ->select('*')
        ->where('creator_id', '=', Auth::user()->id)
        ->whereYear('created_at', '=', date('Y'))
        ->get()
        ->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('m');
        });

        foreach ($submittedReports as $key => $value) {
            $reportCount[(int)$key] = count($value);
        }

        for ($i = 1; $i <= 12; $i++) {
            if(!empty($reportCount[$i])) {
                $reportArr[$i] = $reportCount[$i];
            }
            else {
                $reportArr[$i] = 0;
            }
        }

        if(now()->month < 7) {
            $chart = (new LarapexChart)->lineChart()
            ->setTitle('Submitted Reports')
            ->addLine('Reports Submitted', [$reportArr[1], $reportArr[2], $reportArr[3], $reportArr[4], $reportArr[5], $reportArr[6]])
            ->setXAxis(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'])
            ->setColors(['#ffc63b'])
            ->toVue();
        }
        else {
            $chart = (new LarapexChart)->lineChart()
            ->setTitle('Submitted Reports')
            ->addLine('Reports Submitted', [$reportArr[7], $reportArr[8], $reportArr[9], $reportArr[10], $reportArr[11], $reportArr[12]])
            ->setXAxis(['Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'])
            ->setColors(['#ffc63b'])
            ->toVue();
        }
        

        return Inertia::render('Dashboard', [
            'activeReports' => $activeReports,
            'chart' => $chart
        ]);
    }
}
