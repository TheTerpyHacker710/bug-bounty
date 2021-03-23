<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Models\activeReports;
use App\Models\Program;
use App\Models\Report;
use App\Models\User;
use App\Models\VerificationAssignment;
use App\Models\VerificationSubmission;
use Inertia\Inertia;
Use Auth;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index() {
        $reportCount = [];
        $reportArr = [];
        $verificationCount = [];
        $verificationArr = [];
        $monthsArr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];

        $userInfo = Auth::user();

        $activeReports = Auth::user()->activeReports->load('program');

        $activeVerifications = VerificationAssignment::where('assignee_id', Auth::id())
        ->where('status', 'pending')
        ->with(['verificationBatch:id,report_id', 'verificationBatch.report:id,procedure,program_id', 'verificationBatch.report.program:id,Title,Excerpt']) 
        ->orderBy('created_at')
        ->get();

        $submittedVerifications = VerificationSubmission::select('id')
        ->whereHas('verificationAssignment', function($query) {
            $query->where('assignee_id', Auth::id());
        })
        ->whereYear('created_at', date('Y'))
        ->get()
        ->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('m');
        });

        $submittedReports = Report::select('id')
        ->where('creator_id', Auth::id())
        ->whereYear('created_at', date('Y'))
        ->get()
        ->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('m');
        });

        //ADD FUNCTIONALITY TO COUNT THE AMOUNT OF AWARDS EACH USER HAS
        $leaderboard = User::select('id', 'username', 'reputation')
        ->orderBy('reputation', 'desc')
        ->limit(10)
        ->get();

        foreach ($submittedReports as $key => $value) {
            $reportCount[(int)$key] = count($value);
        }

        foreach ($submittedVerifications as $key => $value) {
            $verificationCount[(int)$key] = count($value);
        }

        for ($i = 1; $i <= 12; $i++) {
            if(!empty($reportCount[$i])) {
                $reportArr[$i] = $reportCount[$i];
            }
            else {
                $reportArr[$i] = 0;
            }

            if(!empty($verificationCount[$i])) {
                $verificationArr[$i] = $verificationCount[$i];
            }
            else {
                $verificationArr[$i] = 0;
            }
        }

        if(now()->month < 7) {
            $chart = (new LarapexChart)->lineChart()
            ->setTitle('User Activity (6 Months)')
            ->addData('Reports Submitted', [$reportArr[1], $reportArr[2], $reportArr[3], $reportArr[4], $reportArr[5], $reportArr[6]])
            ->addData('Verifications Submitted', [$verificationArr[1], $verificationArr[2], $verificationArr[3], $verificationArr[4], $verificationArr[5], $verificationArr[6]])
            ->setXAxis(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'])
            ->setColors(['#ffc63b', '#ff6384'])
            ->toVue();
        }
        else {
            $i = now()->month;
            $chart = (new LarapexChart)->lineChart()
            ->setTitle('User Activity (6 Months)')
            ->addData('Reports Submitted', [$reportArr[$i-5], $reportArr[$i-4], $reportArr[$i-3], $reportArr[$i-2], $reportArr[$i-1], $reportArr[$i]])
            ->addData('Verifications Submitted', [$verificationArr[$i-5], $verificationArr[$i-4], $verificationArr[$i-3], $verificationArr[$i-2], $verificationArr[$i-1], $verificationArr[$i]])
            ->setXAxis([$monthsArr[$i-6], $monthsArr[$i-5], $monthsArr[$i-4], $monthsArr[$i-3], $monthsArr[$i-2], $monthsArr[$i-1]])
            ->setColors(['#ffc63b', '#ff6384'])
            ->toVue();
        }
        
        return Inertia::render('Dashboard', [
            'userInfo' => $userInfo,
            'activeReports' => $activeReports,
            'activeVerifications' => $activeVerifications,
            'leaderboard' => $leaderboard,
            'chart' => $chart
        ]);
    }
}
