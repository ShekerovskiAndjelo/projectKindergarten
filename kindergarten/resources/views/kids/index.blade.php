@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ __('Kids') }}
                    <a href="{{ route('kids.create') }}" class="btn btn-primary float-right">{{ __('Register Kid') }}</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Group</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kids as $kid)
                                <tr>
                                    <td>{{ $kid->name }}</td>
                                    <td>{{ $kid->age }}</td>
                                    <td>
                                        @if ($kid->name)
                                            {{ $kid->group->name ?? 'No Group' }}
                                        @else
                                            {{ $kid->group->name ?? '' }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('kids.edit', $kid->id) }}" class="btn btn-primary">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No kids found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
