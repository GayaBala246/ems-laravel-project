<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private function getEmployee()
    {
        return Employee::where('email', Auth::user()->email)->first();
    }

    public function index()
    {
        $noOfCurrentMonthShifts = Shift::whereMonth('shift_date', Carbon::now()->month)
            ->whereYear('shift_date', Carbon::now()->year)
            ->where('emp_id', $this->getEmployee()->id)
            ->count();

        $totalEarnings = Payroll::where('emp_id', $this->getEmployee()->id)
            ->where('status', 'Paid')
            ->whereMonth('week_start', Carbon::now()->month)
            ->sum('gross_salary');

        return view('auth.user.index', compact('noOfCurrentMonthShifts', 'totalEarnings'));
    }

    public function shiftsList()
    {
        $shifts = Shift::where('emp_id', $this->getEmployee()->id)->get();
        foreach ($shifts as $shift) {
            if ($shift->start_time) {
                // If 'checked_in' is a varchar or string, convert to Carbon and format it
                $shift->start_time = \Carbon\Carbon::parse($shift->start_time)->format('g:i A');
            }
            if ($shift->end_time) {
                // If 'checked_in' is a varchar or string, convert to Carbon and format it
                $shift->end_time = \Carbon\Carbon::parse($shift->end_time)->format('g:i A');
            }
            if ($shift->checked_in) {
                // If 'checked_in' is a varchar or string, convert to Carbon and format it
                $shift->checked_in = \Carbon\Carbon::parse($shift->checked_in)->format('g:i A');
            }

            if ($shift->checked_out) {
                // If 'checked_out' is a varchar or string, convert to Carbon and format it
                $shift->checked_out = \Carbon\Carbon::parse($shift->checked_out)->format('g:i A');
            }
        }
        return view('auth.user.shifts', compact('shifts'));
    }

    public function payrollsList()
    {
        $payrolls = Payroll::where('emp_id', $this->getEmployee()->id)
            ->where('status', 'Paid')->get();
        return view('auth.user.payrolls', compact('payrolls'));
    }
}
