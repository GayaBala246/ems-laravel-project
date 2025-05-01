@extends('auth.layouts.app')

@section('title')
    Update Payroll
@endsection

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Payroll Update</h5>
                                <form class="needs-validation" id="update_payroll" novalidate>
                                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="id" id="_token" value="{{ $payroll->id }}">
                                    <div class="position-relative form-group">
                                        <label for="exampleEmail" class="">List of Employee</label>
                                        <select name="employee" id="employee" class="form-control">
                                            <option value="">Select Employee</option>
                                            @forelse ($employees as $employee)
                                                @if ($employee->id == $payroll->emp_id)
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
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="week_start" class="">Week Start
                                        </label>
                                        <input name="week_start" id="week_start" type="date" class="form-control"
                                            value="{{ $payroll->week_start }}" readonly>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="week_end" class="">Week End
                                        </label>
                                        <input name="week_end" id="week_end" type="date" class="form-control"
                                            value="{{ $payroll->week_end }}" readonly>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="total_hours" class="">Total Hours
                                        </label>
                                        <input name="total_hours" id="total_hours" type="text" class="form-control"
                                            value="{{ $payroll->total_hours }}" readonly>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="gross_salary" class="">Gross Salary
                                        </label>
                                        <input name="gross_salary" id="gross_salary" type="text" class="form-control"
                                            value="{{ $payroll->gross_salary }}" readonly>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="status" class="">Status
                                        </label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="">Select Status</option>
                                            @if ($payroll->status == 'Pending')
                                                @php
                                                    $selected = 'selected';
                                                @endphp
                                            @else
                                                @php
                                                    $selected = '';
                                                @endphp
                                            @endif
                                            <option value="Pending" {{ $selected }}>Pending</option>
                                            @if ($payroll->status == 'Paid')
                                                @php
                                                    $selected = 'selected';
                                                @endphp
                                            @else
                                                @php
                                                    $selected = '';
                                                @endphp
                                            @endif
                                            <option value="Paid" {{ $selected }}>Paid</option>
                                        </select>
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
        $("#update_payroll").submit(function(e) {
            e.preventDefault();
            const formdata = new FormData(this);

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.payroll.update') }}',
                data: formdata,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: (data) => {
                    if (data.success === true) {
                        alert(data.message);
                        window.location.href = '/payroll/list';
                    }
                    else {
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
