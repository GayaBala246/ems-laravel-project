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


class ShiftController extends Controller
{
    public function index(): View
    {
        $shifts = Shift::latest()->get();
        return view('auth.admin.shifts.index', compact('shifts'));
    }

    public function add()
    {
        $employees =  Employee::where('status', 'active')->latest()->get();
        return view('auth.admin.shifts.create', compact('employees'));
    }

    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'employee' => 'required',
            'shift_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',  // AM/PM format validation
            'end_time' => 'required|after:start_time',  // End time must be after start time
        ], [
            // Custom error messages for specific fields
            'shift_date.required' => 'The shift date is required.',
            'shift_date.date' => 'The shift date must be a valid date.',
            'shift_date.after_or_equal' => 'The shift date must be today or in the future.',
            'shift_date.after_or_equal' => 'The shift date should be today or future dates.',
            'end_time.after' => 'The end time must be after the start time.',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors()
            ], 422); // <- very important!
        } else {
            $shift = new Shift();

            $shift->title = $request->title;
            $shift->emp_id = $request->employee;
            $shift->shift_date = $request->shift_date;
            $shift->start_time = $request->start_time;
            $shift->end_time = $request->end_time;
            $result = $shift->save();

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => ['Shift added successfully']
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => ['Shift not add successfully']
                ]);
            }
        }
    }

    public function edit($id)
    {
        $shift = Shift::findOrFail($id);
        $employees =  Employee::where('status', 'active')->latest()->get();
        return view('auth.admin.shifts.update', compact(['shift', 'employees']));
    }

    public function update(Request $request)
    {
        $shift = Shift::findOrFail($request->id);
        // Check if the shift has a check-in
        if (!is_null($shift->checked_in)) {
            // If check-in exists, do not allow update
            return response()->json([
                'success' => false,
                'message' => [
                    'Cannot update shift with check-in'
                ]
            ]);
        } else {
            $validation = Validator::make($request->all(), [
                'title' => 'required',
                'employee' => 'required',
                'shift_date' => 'required|date|after_or_equal:today',
                'start_time' => 'required',  // AM/PM format validation
                'end_time' => 'required|after:start_time',  // End time must be after start time
            ], [
                // Custom error messages for specific fields
                'shift_date.required' => 'The shift date is required.',
                'shift_date.date' => 'The shift date must be a valid date.',
                'shift_date.after_or_equal' => 'The shift date must be today or in the future.',
                'shift_date.after_or_equal' => 'The shift date should be today or future dates.',
                'end_time.after' => 'The end time must be after the start time.',
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'errors' => $validation->errors()
                ], 422); // <- very important!
            } else {

                $shift->title = $request->title;
                $shift->emp_id = $request->employee;
                $shift->shift_date = $request->shift_date;
                $shift->start_time = $request->start_time;
                $shift->end_time = $request->end_time;

                $result = $shift->save();

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => [
                            'Shift Updated Successfully'
                        ]
                    ]);
                } else {
                    return response()->json([
                        "success" => false,
                        'message' => [
                            'Shift Update Unsuccessful'
                        ]
                    ]);
                }
            }
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $shift = Shift::findOrFail($id);

        // Check if shift has a check-in
        if (!is_null($shift->checked_in)) {
            // If check-in exists, do not allow deletion
            return response()->json([
                'success' => false,
                'message' => [
                    'Cannot delete shift with check-in'
                ]
            ]);
        }

        // Proceed with deletion if no check-in
        $result = $shift->delete();

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => [
                    'Shift Deleted Successfully'
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => [
                    'Shift deletion Unsuccessful'
                ]
            ]);
        }
    }

    public function todayList(): View
    {
        $today = Carbon::now('Australia/Sydney')->toDateString();
        $shifts = Shift::where('shift_date', $today)->get();

        return view('auth.admin.shifts.today-shifts', compact('shifts'));
    }

    public function pendingList(): View
    {
        $today = Carbon::now('Australia/Sydney')->toDateString();
        $shifts = Shift::whereDate('shift_date', '<', $today) // Exclude future shifts
            ->where(function ($query) {
                $query->whereNull('checked_in')
                    ->orWhereNull('checked_out');
            })
            ->get();

        return view('auth.admin.shifts.pending-shifts', compact('shifts'));
    }

    public function attendance($id)
    {
        $shift = Shift::findOrFail($id);
        return view('auth.admin.shifts.attendance', compact('shift'));
    }

    public function checkedinout(Request $request)
    {
        $shift = Shift::findOrFail($request->id);
        // Check if the shift's date falls within a processed payroll range
        $payrollExists = Payroll::whereDate('week_start', '<=', $shift->shift_date)
            ->where('emp_id', $shift->emp_id)
            ->whereDate('week_end', '>=', $shift->shift_date)
            ->exists();

        if ($payrollExists) {
            // If payroll exists for the shift's date, do not allow update
            return response()->json([
                'success' => false,
                'message' => [
                    'This shift cannot be updated because payroll has already been processed.'
                ]
            ]);
        } else {
            $shift->checked_in = $request->checked_in;
            $shift->checked_out = $request->checked_out;

            //calculate total worked hours
            if (!is_null($shift->checked_in) && !is_null($shift->checked_out)) {
                $startTime = Carbon::parse($shift->checked_in);
                $endTime = Carbon::parse($shift->checked_out);
                // Convert worked hours to decimal
                $workedHours = round($endTime->diffInMinutes($startTime) / 60, 2); // Example: 8.75

                // Deduct 0.5 hours if more than 6 hours worked (Lunch Break)
                if ($workedHours > 6) {
                    $workedHours -= 0.5;
                }

                $shift->hours_worked  = $workedHours;
            }
            $result = $shift->save();

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => [
                        'Checked In-Out Updated Successfully'
                    ]
                ]);
            } else {
                return response()->json([
                    "success" => false,
                    'message' => [
                        'Checked n-Out Update Unsuccessful'
                    ]
                ]);
            }
        }
    }
}
