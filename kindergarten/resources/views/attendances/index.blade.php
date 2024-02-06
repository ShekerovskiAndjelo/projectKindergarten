@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Attendance Records') }}</div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Group</th>
                                    <th>Kid</th>
                                    <th>Status</th>
                                    <th>Actions</th> <!-- New column for Actions -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $attendance)
                                    <tr>
                                        <td>{{ $attendance->date }}</td>
                                        <td>{{ $attendance->group->name }}</td>
                                        <td>{{ $attendance->kid->name }}</td>
                                        <td>{{ $attendance->status }}</td>
                                        <td>
                                            <a href="{{ route('attendances.edit', $attendance->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                        </td> <!-- Edit button -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
