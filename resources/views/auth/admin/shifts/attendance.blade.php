@extends('auth.layouts.app')

@section('title')
    Add Attendance
@endsection

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Add Attendance </h5>
                                <form class="" id="add_attendance">
                                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

                                    <div class="position-relative form-group">
                                        <label for="shiftTitle" class="">Title
                                        </label>
                                        <input name="title" id="title" placeholder="Enter Shift Title" type="text"
                                            readonly="true" value="{{ $shift->title }}" class="form-control">
                                        <input name="id" value="{{ $shift->id }}" id="id" type="hidden"
                                            class="form-control">
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="empName" class="">Employee Name
                                        </label>
                                        <input name="emp_id" id="emp_id" type="text" readonly="true"
                                            value="{{ $shift->employee->name }}" class="form-control">
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="shift_date" class="">Shift Date
                                        </label>
                                        <input name="shift_date" id="shift_date" type="date" readonly="true"
                                            value="{{ $shift->shift_date }}" class="form-control">
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="start_time" class="">Shift Start Time
                                        </label>
                                        <input name="start_time" id="start_time" type="time" readonly="true"
                                            value="{{ $shift->start_time }}" class="form-control">
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="end_time" class="">Shift End Time
                                        </label>
                                        <input name="end_time" id="end_time" type="time" readonly="true"
                                            value="{{ $shift->end_time }}" class="form-control">
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="checked_in" class="">Checked-In Time
                                        </label>
                                        <input name="checked_in" id="checked_in" placeholder="Enter Checked-In Time"
                                            type="time" class="col-md-4 mr-2 form-control"
                                            value="{{ $shift->checked_in }}">
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="checked_out" class="">Checked-Out Time
                                        </label>
                                        <input name="checked_out" id="checked_out" placeholder="Enter Checked-Out Time"
                                            type="time" class="col-md-4 mr-2 form-control"
                                            value="{{ $shift->checked_out }}">
                                    </div>
                                    <button type="submit" class="mt-1 btn btn-primary">Check In</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const checked_in = document.getElementById('checked_in');
            const checked_out = document.getElementById('checked_out');
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');

            if (checked_in.value == "") {
                checked_in.value = `${hours}:${minutes}`;
                checked_out.readOnly = true;
            } else {
                checked_out.readOnly = false;
                if (checked_out.value == "") {
                    checked_out.value = `${hours}:${minutes}`;
                }
            }
        });

        $('#add_attendance').submit(function(e) {
            e.preventDefault();
            const formdata = new FormData(this);

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.shift.checkedinout') }}',
                data: formdata,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: (data) => {
                    if (data.success == true) {
                        alert(data.message);
                        window.location.href = '/shift/today';
                    }
                }
            })

        })
    </script>
@endsection
