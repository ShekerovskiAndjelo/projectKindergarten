@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Kindergarten') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('kindergartens.update', $kindergarten->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ $kindergarten->name }}" required autofocus>
                        </div>

                        <div class="form-group">
                            <label for="city">{{ __('City') }}</label>
                            <input id="city" type="text" class="form-control" name="city" value="{{ $kindergarten->city }}" required>
                        </div>

                        <div class="form-group">
                            <label for="street">{{ __('Street') }}</label>
                            <input id="street" type="text" class="form-control" name="street" value="{{ $kindergarten->street }}" required>
                        </div>

                        <div class="form-group">
                            <label for="managed_by">{{ __('Managed By') }}</label>
                            <select id="managed_by" class="form-control" name="managed_by" required>
                                <option value="" disabled>Select director</option>
                                @foreach($directors as $director)
                                    <option value="{{ $director->id }}" {{ $kindergarten->managed_by == $director->id ? 'selected' : '' }}>{{ $director->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                            <a href="{{ route('kindergartens.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
