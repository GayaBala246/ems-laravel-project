@extends('auth.layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="row">
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-midnight-bloom">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Today Shifts</div>
                                <div class="widget-subheading">Number of shifts</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white"><span>{{ $noOfTodayShifts }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-arielle-smile">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Employees</div>
                                <div class="widget-subheading">Total active employees </div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white"><span>{{ $noOfEmployees }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-grow-early">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Payrolls</div>
                                <div class="widget-subheading">Today total amount</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white"><span>0%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-header">Active Employees
                        </div>
                        <div class="table-responsive">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Id</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Phone</th>
                                        <th class="text-center">Address</th>
                                        <th class="text-center">Pay Rate</th>
                                        <th class="text-center">Image</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($employees as $employee)
                                        <tr>
                                            <td class="text-center text-muted">{{ $employee->id }}</td>
                                            <td class="text-center" >{{ $employee->name }}</td>
                                            <td class="text-center">{{ $employee->email }}</td>
                                            <td class="text-center">{{ $employee->phone }}</td>
                                            <td class="text-center">{{ $employee->address }}</td>
                                            <td class="text-center">{{ $employee->pay_rate }}</td>
                                            <td>
                                                @if ($employee->image && file_exists(storage_path('app/public/' . $employee->image)))
                                                    <img src="{{ asset('storage/' . $employee->image) }}" width="60"
                                                        alt="Employee Image">
                                                @else
                                                    <img src="{{ asset('images/no-user-image.jpg') }}" width="60"
                                                        alt="Employee Image">
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
