<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(): View
    {
        $payrolls = Payroll::latest()->get();
        return view('auth.admin.payrolls.index', compact('payrolls'));
    }

    public function add()
    {
        $employees =  Employee::where('status', 'active')->latest()->get();
        return view('auth.admin.payrolls.create', compact('employees'));
    }

    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'employee' => 'required|exists:employees,id',
            'week_end' => 'required|date',
            'week_start' => 'required|date|after_or_equal:week_start',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors()
            ], 422); // <- very important!
        } else {

            $employeeId = $request->employee;
            $weekStart = $request->week_start;
            $weekEnd = $request->week_end;


            // Check if payroll already exists for the employee within the date range
            $existingPayroll = Payroll::where('emp_id', $employeeId)
                ->where(function ($query) use ($weekStart, $weekEnd) {
                    $query->whereBetween('week_start', [$weekStart, $weekEnd])
                        ->orWhereBetween('week_end', [$weekStart, $weekEnd])
                        ->orWhere(function ($query) use ($weekStart, $weekEnd) {
                            $query->where('week_start', '<=', $weekStart)
                                ->where('week_end', '>=', $weekEnd);
                        });
                })
                ->exists();

            if ($existingPayroll) {
                return response()->json([
                    'success' => false,
                    'message' => ['A payroll record already exists for this employee within the selected date range']
                ]);
            } else {

                // Check if the employee has any shifts within the specified week
                $shifts = Shift::where('emp_id', $employeeId)
                    ->whereBetween('shift_date', [$weekStart, $weekEnd])
                    ->exists();

                if (!$shifts) {
                    return response()->json([
                        'success' => false,
                        'message' => ['No shifts found for this employee within the selected date range']
                    ]);
                }

                $hasPendingShifts = Shift::where('emp_id', $employeeId)
                ->whereBetween('shift_date', [$weekStart, $weekEnd])
                ->whereNull('checked_in')
                ->whereNull('checked_out')
                ->exists();


                if ($hasPendingShifts) {
                    return response()->json([
                        'success' => false,
                        'message' => ['There are some pending shifts which are not checked IN/OUt for this employee within the selected week range. Please finish the shift ']
                    ]);
                }
                else {
                    $shifts = Shift::where('emp_id', $employeeId)
                    ->whereBetween('shift_date', [$weekStart, $weekEnd])
                    ->get();

                $employee = Employee::findOrFail($employeeId);
                $payRate = $employee->pay_rate; // Pay per hour

                $totalHours = 0;

                // Calculate total hours worked from shifts
                foreach ($shifts as $shift) {

                    $totalHours += $shift->hours_worked;
                }
                // Calculate salary
                $totalSalary = $totalHours * $payRate;

                $paroll = new Payroll();
                $paroll->emp_id = $employeeId;
                $paroll->week_start = $weekStart;
                $paroll->week_end = $weekEnd;
                $paroll->total_hours = $totalHours;
                $paroll->gross_salary = $totalSalary;
                $result = $paroll->save();

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => ['Payroll calculated successfully']
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => ['Payroll calculation unsuccessfull']
                    ]);
                }

                }
            }
        }
    }

    public function edit($id)
    {
        $payroll = Payroll::findOrFail($id);
        $employees =  Employee::where('status', 'active')->latest()->get();
        return view('auth.admin.payrolls.update', compact(['payroll', 'employees']));
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'employee' => 'required|exists:employees,id',
            'week_end' => 'required|date',
            'week_start' => 'required|date|after_or_equal:week_start',
            'status' => 'required|in:Pending,Paid',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors()
            ], 422); // <- very important!
        } else {
            $id = $request->id;
            $payroll = Payroll::findOrFail($id);

            $employeeId = $request->employee;
            $weekStart = $request->week_start;
            $weekEnd = $request->week_end;
            $status = $request->status;

            // Check if payroll already exists for the employee within the date range
            $existingPayroll = Payroll::where('emp_id', $employeeId)
                ->where('id', '!=', $id)
                ->where(function ($query) use ($weekStart, $weekEnd) {
                    $query->whereBetween('week_start', [$weekStart, $weekEnd])
                        ->orWhereBetween('week_end', [$weekStart, $weekEnd])
                        ->orWhere(function ($query) use ($weekStart, $weekEnd) {
                            $query->where('week_start', '<=', $weekStart)
                                ->where('week_end', '>=', $weekEnd);
                        });
                })
                ->exists();
            if ($existingPayroll) {
                return response()->json([
                    'success' => false,
                    'message' => ['A payroll record already exists for this employee within the selected date range']
                ]);
            } else {
                $shifts = Shift::where('emp_id', $employeeId)
                    ->whereBetween('shift_date', [$weekStart, $weekEnd])
                    ->get();

                $employee = Employee::findOrFail($employeeId);
                $payRate = $employee->pay_rate; // Pay per hour

                $totalHours = 0;

                // Calculate total hours worked from shifts
                foreach ($shifts as $shift) {
                    $totalHours += $shift->hours_worked;
                }
                // Calculate salary
                $totalSalary = $totalHours * $payRate;



                $payroll->emp_id = $employeeId;
                $payroll->week_start = $weekStart;
                $payroll->week_end = $weekEnd;
                $payroll->total_hours = $totalHours;
                $payroll->gross_salary = $totalSalary;
                $payroll->status = $status;
                $payroll->save();

                return response()->json([
                    'success' => true,
                    'message' => ['Payroll updated successfully']
                ]);
            }
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        // Check if the payroll record exists
        $payroll = Payroll::findOrFail($id);
        //if the payroll is already paid, do not delete
        if ($payroll->status == 'Paid') {
            return response()->json([
                'success' => false,
                'message' => ['Payroll already paid, cannot be deleted']
            ]);
        }else{
            $payroll->delete();
            return response()->json([
                'success' => true,
                'message' => ['Payroll deleted successfully']
            ]);
        }
    }
}
