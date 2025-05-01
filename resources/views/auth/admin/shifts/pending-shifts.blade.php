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
                        <h3>List of Pending Shifts</h3>
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
                                        <th>Check In Time</th>
                                        <th>Check Out Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @foreach ($shifts as $shift)
                                    <tr>
                                        <td>{{ $shift->id }}</td>
                                        <td>{{ $shift->title }}</td>
                                        <td>{{ $shift->employee->name }}</td>
                                        <td>{{ $shift->shift_date }}</td>
                                        <td>{{ $shift->start_time }}</td>
                                        <td>{{ $shift->checked_in ?? '--:--' }}</td>
                                        <td>{{ $shift->checked_out ?? '--:--' }}</td>
                                        <td>{{ $shift->end_time }}</td>
                                        <td>
                                            <a href="{{ route('admin.shift.attendance', ['id' => $shift->id]) }}"
                                                class="mr-2 btn-icon btn-icon-only btn btn-outline-alternate"><i
                                                    class="pe-7s-alarm btn-icon-wrapper"> </i></a>
                                        </td>
                                        <td>
                                            <button class="mr-2 btn-icon btn-icon-only btn btn-outline-danger"
                                                id="delete-shift" data-id='{{ $shift->id }}'><i
                                                    class="pe-7s-trash btn-icon-wrapper"> </i></button>
                                        </td>
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
