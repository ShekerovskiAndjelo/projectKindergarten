@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ __('Groups') }}
                    <a href="{{ route('groups.create') }}" class="btn btn-primary float-right">{{ __('Add Group') }}</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Period</th>
                                <th scope="col">Kindergarten</th>
                                <th scope="col">Teacher</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groups as $group)
                                <tr>
                                    <th scope="row">{{ $group->id }}</th>
                                    <td>{{ $group->name }}</td>
                                    <td>{{ $group->period }}</td>
                                    <td>{{ $group->kindergarten->name }}</td>
                                    <td>{{ $group->teacher->name }}</td>
                                    <td>
                                        @if (auth()->user()->hasRole('director'))
                                            @if ($group->trashed())
                                                <form action="{{ route('groups.restore', $group->id) }}" method="POST">
                                                    @csrf
                                                    @method('GET')
                                                    <button type="submit" class="btn btn-primary btn-sm">Restore</button>
                                                </form>
                                            @else
                                                <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                                <form action="{{ route('groups.destroy', $group->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this group?')">Delete</button>
                                                </form>
                                            @endif
                                        @elseif (auth()->user()->hasRole('teacher'))
                                            <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                        @endif
                                    </td>
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
