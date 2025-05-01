@extends('auth.layouts.app')

@section('title')
    Create Payroll
@endsection

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Payroll Create</h5>
                                <form class="needs-validation" id="create_payroll" novalidate>
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
                                        <label for="week_start" class="">Week Start
                                        </label>
                                        <input name="week_start" id="week_start" type="date" class="form-control"
                                            required>
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="week_end" class="">Week End
                                        </label>
                                        <input name="week_end" id="week_end" type="date" class="form-control" required>
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                    <button type="submit" class="mt-1 btn btn-primary">Calculate</button>
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
            const weekEnd = document.getElementById('week_end');
            const weekStart = document.getElementById('week_start');

            weekEnd.addEventListener('keydown', function(event) {
                event.preventDefault(); // Block typing
            });

            weekStart.addEventListener('keydown', function(event) {
                event.preventDefault(); // Block typing
            });

            const today = new Date();
            const day = today.getDay(); // 0 (Sun) - 6 (Sat)

            // Get the previous Monday
            const diffToMonday = day === 0 ? 6 : day - 1; // How many days since last Monday
            const prevMonday = new Date(today);
            prevMonday.setDate(today.getDate() - diffToMonday - 7); // Go back to last week's Monday

            // Format as YYYY-MM-DD
            const minDate = prevMonday.toISOString().split('T')[0];

            weekStart.setAttribute('min', minDate);
            weekStart.addEventListener('change', function() {
                const startDate = new Date(weekStart.value);
                const endDate = new Date(startDate);
                endDate.setDate(endDate.getDate() + 6); // Add 6 days to the start date
                weekEnd.value = endDate.toISOString().split('T')[
                    0]; // Set the end date in YYYY-MM-DD format
            });
            weekEnd.setAttribute('min', minDate);
            weekEnd.addEventListener('change', function() {
                const startDate = new Date(weekStart.value);
                const endDate = new Date(weekEnd.value);
                if (endDate < startDate) {
                    alert("Week End date cannot be earlier than Week Start date.");
                    weekEnd.value = '';
                }
            });


        });
    </script>
@endsection
