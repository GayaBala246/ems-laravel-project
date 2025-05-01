@extends('auth.layouts.app')

@section('title')
    List of Payrolls
@endsection

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h3>List of Payrolls</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="list_payroll" class="table" style="width:90%">
                                <thead>
                                    <tr>
                                        <th>Week Start</th>
                                        <th>Week End</th>
                                        <th>Total Hours</th>
                                        <th>Total Pay</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                @foreach ($payrolls as $payroll)
                                    <tr>
                                        <td>{{ $payroll->week_start }}</td>
                                        <td>{{ $payroll->week_end }}</td>
                                        <td>{{ $payroll->total_hours }}</td>
                                        <td>{{ $payroll->gross_salary }}</td>
                                        <td>{{ $payroll->status }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

