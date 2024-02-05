@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ __('Kindergartens') }}
                    <a href="{{ route('kindergartens.create') }}" class="btn btn-primary float-right">{{ __('Add Kindergarten') }}</a>
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">City</th>
                                <th scope="col">Street</th>
                                <th scope="col">Managed By</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kindergartens as $kindergarten)
                                <tr>
                                    <th scope="row">{{ $kindergarten->id }}</th>
                                    <td>{{ $kindergarten->name }}</td>
                                    <td>{{ $kindergarten->city }}</td>
                                    <td>{{ $kindergarten->street }}</td>
                                    <td>{{ $kindergarten->director->name }}</td>
                                    <td>
                                        @if ($kindergarten->deleted_at)
                                            <form action="{{ route('kindergartens.restore', $kindergarten->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-primary btn-sm">Restore</button>
                                            </form>
                                        @else
                                            <a href="{{ route('kindergartens.edit', $kindergarten->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ route('kindergartens.destroy', $kindergarten->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $kindergartens->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
