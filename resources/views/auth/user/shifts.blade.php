@extends('auth.layouts.app')

@section('title')
    List of Shifts
@endsection

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h3>List of Shifts</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="list_shift" class="table" style="width:90%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Title</th>
                                        <th>Employee</th>
                                        <th>Shift Date</th>
                                        <th>Shift Start Time</th>
                                        <th>Shift End Time</th>
                                        <th>Checked In</th>
                                        <th>Checked Out</th>
                                    </tr>
                                </thead>
                                @foreach ($shifts as $shift)
                                    <tr>
                                        <td>{{ $shift->id }}</td>
                                        <td>{{ $shift->title }}</td>
                                        <td>{{ $shift->employee->name }}</td>
                                        <td>{{ $shift->shift_date }}</td>
                                        <td>{{ $shift->start_time }}</td>
                                        <td>{{ $shift->end_time }}</td>
                                        <td>{{ $shift->checked_in ?? '--:--' }}</td>
                                        <td>{{ $shift->checked_out ?? '--:--' }}</td>
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


