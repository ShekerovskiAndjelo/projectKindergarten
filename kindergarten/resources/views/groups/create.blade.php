@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create Group') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('groups.store') }}">
                        @csrf

                        <!-- Name Field -->
                        <div class="form-group">
                            <label for="name">{{ __('Name') }}:</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <!-- Period Field -->
                        <div class="form-group">
                            <label for="period">{{ __('Period') }}:</label>
                            <input type="text" name="period" id="period" class="form-control" required>
                        </div>

                        <!-- Kindergarten Name (Disabled) -->
<div class="form-group">
    <label for="kindergarten_name">{{ __('Kindergarten') }}:</label>
    <input type="text" id="kindergarten_name" class="form-control" value="{{ $kindergarten->name }}" disabled>
</div>

<!-- Hidden Kindergarten ID -->
<input type="hidden" name="kindergarten_id" value="{{ $kindergarten->id }}">

                        <!-- Teacher ID Field (Select Dropdown) -->
                        <div class="form-group">
                            <label for="teacher_id">{{ __('Teacher') }}:</label>
                            <select name="teacher_id" id="teacher_id" class="form-control" required>
                                <option value="" disabled>{{ __('Select Teacher') }}</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ __('Create Group') }}</button>
                            <a href="{{ route('groups.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
