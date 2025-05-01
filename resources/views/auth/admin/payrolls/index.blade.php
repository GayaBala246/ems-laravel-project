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
                                        <th>Id</th>
                                        <th>Employee</th>
                                        <th>Week Start</th>
                                        <th>Week End</th>
                                        <th>Total Hours</th>
                                        <th>Total Pay</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @foreach ($payrolls as $payroll)
                                    <tr>
                                        <td>{{ $payroll->id }}</td>
                                        <td>{{ $payroll->employee->name }}</td>
                                        <td>{{ $payroll->week_start }}</td>
                                        <td>{{ $payroll->week_end }}</td>
                                        <td>{{ $payroll->total_hours }}</td>
                                        <td>{{ $payroll->gross_salary }}</td>
                                        <td>{{ $payroll->status }}</td>
                                        <td>
                                            <a href="{{ route('admin.payroll.edit', ['id' => $payroll->id]) }}"
                                                class="mr-2 btn-icon btn-icon-only btn btn-outline-info"><i
                                                    class="pe-7s-pen btn-icon-wrapper"> </i></a>

                                            <button class="mr-2 btn-icon btn-icon-only btn btn-outline-danger"
                                                id="delete-payroll" data-id='{{ $payroll->id }}'><i
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

@section('footer')
    <script>
        $(document).ready(function() {
            $('#list_payroll').DataTable();
        });

        $(document).on('click', '#delete-payroll', function(e) {
            e.preventDefault();

            const id = $(this).data('id');
            if (id != "") {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.payroll.delete') }}",
                    data: {
                        id,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    success: (data) => {
                        if (data.success === true) {
                            alert(data.message);
                            window.location.href = "{{ route('admin.payroll.list') }}"
                        } else {
                            alert(data.message);
                        }
                    }
                })
            }
        })
    </script>
@endsection
