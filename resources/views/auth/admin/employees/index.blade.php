@extends('auth.layouts.app')

@section('title')
    List of Employees
@endsection

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h3>List of Employees</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="list_employee" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Pay Rate</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td>{{ $employee->id }}</td>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ $employee->email }}</td>
                                        <td>{{ $employee->phone }}</td>
                                        <td>{{ $employee->address }}</td>
                                        <td>{{ $employee->pay_rate }}</td>
                                        <td>
                                            @if ($employee->image && file_exists(storage_path('app/public/' . $employee->image)))
                                                <img src="{{ asset('storage/' . $employee->image) }}" width="60"
                                                    alt="Employee Image">
                                            @else
                                                <img src="{{ asset('images/no-user-image.jpg') }}" width="60"
                                                    alt="Employee Image">
                                            @endif
                                        </td>
                                        <td>
                                        <div
                                            class="badge {{ $employee->status == 'Active' ? 'badge-success' : 'badge-warning' }}">
                                            {{ $employee->status }}
                                        </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.employee.edit', ['id' => $employee->id]) }}"
                                                class="mr-2 btn-icon btn-icon-only btn btn-outline-info"><i
                                                    class="pe-7s-pen btn-icon-wrapper"> </i></a>

                                            <button class="mr-2 btn-icon btn-icon-only btn btn-outline-danger"
                                                id="delete-employee" data-id='{{ $employee->id }}'><i
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
            $('#list_employee').DataTable();
        });

        $(document).on('click', '#delete-employee', function(e) {
            e.preventDefault();

            const id = $(this).data('id');
            if (id != "") {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.employee.delete') }}",
                    data: {
                        id,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    success: (data) => {
                        if (data.success == true) {
                            alert(data.message);
                            window.location.href = "{{ route('admin.employee.list') }}"
                        } else {
                            alert(data.message);
                        }
                    }
                })
            }
        })
    </script>
@endsection
