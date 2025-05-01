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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @foreach ($shifts as $shift)
                                    <tr>
                                        <td>{{ $shift->id }}</td>
                                        <td>{{ $shift->title }}</td>
                                        <td>{{ $shift->employee->name }}</td>
                                        <td>{{ $shift->shift_date }}</td>
                                        <td>{{ \Carbon\Carbon::parse($shift->start_time)->format('h:i A') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($shift->end_time)->format('h:i A') }}</td>
                                        <td>
                                            <a href="{{ route('admin.shift.edit', ['id' => $shift->id]) }}"
                                                class="mr-2 btn-icon btn-icon-only btn btn-outline-info"><i
                                                    class="pe-7s-pen btn-icon-wrapper"> </i></a>

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

@section('footer')
    <script>
        $(document).ready(function() {
            $('#list_shift').DataTable();
        });

        $(document).on('click', '#delete-shift', function(e) {
            e.preventDefault();

            const id = $(this).data('id');
            if (id != "") {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.shift.delete') }}",
                    data: {
                        id,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    success: (data) => {
                        if (data.success == true) {
                            alert(data.message);
                            window.location.href = "{{ route('admin.shift.list') }}"
                        } else {
                            alert(data.message);
                        }
                    }
                })
            }
        })
    </script>
@endsection
