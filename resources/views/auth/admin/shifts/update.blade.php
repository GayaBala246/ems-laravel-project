@extends('auth.layouts.app')

@section('title')
    Update Shift
@endsection

@php
    $minDate = \Carbon\Carbon::now()->format('Y-m-d');
@endphp
@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Shift Update</h5>
                                <form class="needs-validation" id="update_shift" novalidate>
                                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                    <div class="position-relative form-group">
                                        <label for="exampleEmail" class="">List of Employee</label>
                                        <select name="employee" id="employee" class="form-control" required>
                                            <option value="">Select Employee</option>
                                            @forelse ($employees as $employee)
                                                @if ($employee->id == $shift->emp_id)
                                                    @php
                                                        $selected = 'selected';
                                                    @endphp
                                                @else
                                                    @php
                                                        $selected = '';
                                                    @endphp
                                                @endif
                                                <option value="{{ $employee->id }}" {{ $selected }}>
                                                    {{ $employee->name }}</option>
                                            @empty
                                                <option value="">Employee list not found</option>
                                            @endforelse
                                        </select>
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="shiftTitle" class="">Title
                                        </label>
                                        <input name="title" id="title" placeholder="Enter Shift Title" type="text"
                                            value="{{ $shift->title }}" class="form-control" required>
                                        <input name="id" value="{{ $shift->id }}" id="id" type="hidden"
                                            class="form-control">
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="shift_date" class="">Shift Date
                                        </label>
                                        <input name="shift_date" id="shift_date" type="date"
                                            value="{{ $shift->shift_date }}" class="form-control" min="{{ $minDate }}"
                                            required>
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="start_time" class="">Shift Start Time
                                        </label>
                                        <input name="start_time" id="start_time" placeholder="Enter Shift Start Time"
                                            type="time" class="form-control" value="{{ $shift->start_time }}" required>
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="end_time" class="">Shift End Time
                                        </label>
                                        <input name="end_time" id="end_time" placeholder="Enter Shift End Time"
                                            type="time" class="form-control" value="{{ $shift->end_time }}" required>
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                    <button type="submit" class="mt-1 btn btn-primary">Update</button>
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
        document.addEventListener("DOMContentLoaded", function() {
            const shiftDate = document.getElementById("shift_date");
            const startTime = document.getElementById("start_time");
            const endTime = document.getElementById("end_time");

            shiftDate.addEventListener('keydown', function(event) {
                event.preventDefault(); // Block typing
            });
            startTime.addEventListener("keydown", function(e) {
                event.preventDefault(); // Block typing
            });

            endTime.addEventListener("keydown", function(e) {
                event.preventDefault(); // Block typing
            });

        });

        $('#update_shift').submit(function(e) {
            e.preventDefault();
            const formdata = new FormData(this);

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.shift.update') }}',
                data: formdata,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: (data) => {
                    if (data.success == true) {
                        alert(data.message);
                        window.location.href = '/shift/list';
                    } else {
                        alert(data.message);
                    }
                },
                error: function(xhr) {
                    // Clear previous success and error styles

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;

                        $.each(errors, function(field, messages) {
                            let input = $(`[name="${field}"]`);
                            input.addClass('is-invalid'); // Add error (red) style
                            input.closest('.form-group').find('.invalid-feedback').text(
                                messages[0]); // Display error message
                        });
                    } else {
                        alert("Something went wrong!");
                    }
                }
            })

        })
    </script>
@endsection
