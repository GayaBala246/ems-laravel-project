<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //Admin Dashboard
    public function index()
    {
        $today = Carbon::now('Australia/Sydney')->toDateString();
        $noOfTodayShifts = Shift::where('shift_date', $today)->get()->count();

        $employees =  Employee::where('status', 'active')->latest()->get();

        $noOfEmployees = Employee::distinct('emp_id')->where('status', 'Active')->get()->count();

        return view('auth.admin.index', compact('noOfTodayShifts', 'noOfEmployees', 'employees'));
    }
}
