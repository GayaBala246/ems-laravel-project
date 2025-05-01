@extends('auth.layouts.app')

@section('title')
    Create Shift
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
                                <h5 class="card-title">Shift Create</h5>
                                <form class="needs-validation" id="create_shift" novalidate>
                                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                    <div class="position-relative form-group">
                                        <label for="exampleEmail" class="">List of Employee</label>
                                        <select name="employee" id="employee" class="form-control" required>
                                            <option value="">Select Employee</option>
                                            @forelse ($employees as $employee)
                                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>

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
                                            class="form-control" required>
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="shift_date" class="">Shift Date
                                        </label>
                                        <input name="shift_date" id="shift_date" type="date" class="form-control"
                                            min="{{ $minDate }}" required>

                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="start_time" class="">Shift Start Time
                                        </label>
                                        <input name="start_time" id="start_time" type="time" class="form-control"
                                            required>
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="end_time" class="">Shift End Time
                                        </label>
                                        <input name="end_time" id="end_time" type="time" class="form-control" required>
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                    <button type="submit" class="mt-1 btn btn-primary">Create</button>
                                </form>
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
        </script>
    @endsection
