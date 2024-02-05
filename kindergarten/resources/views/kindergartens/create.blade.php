@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create Kindergarten') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('kindergartens.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control" name="name" required autofocus>
                        </div>

                        <div class="form-group">
                            <label for="city">{{ __('City') }}</label>
                            <input id="city" type="text" class="form-control" name="city" required>
                        </div>

                        <div class="form-group">
                            <label for="street">{{ __('Street') }}</label>
                            <input id="street" type="text" class="form-control" name="street" required>
                        </div>

                        <div class="form-group">
                            <label for="managed_by">{{ __('Managed By') }}</label>
                            <select id="managed_by" class="form-control" name="managed_by" required>
                                <option value="" disabled>Select director</option>
                                @foreach($directors as $director)
                                    <option value="{{ $director->id }}">{{ $director->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                            <a href="{{ route('kindergartens.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
            @endsection
