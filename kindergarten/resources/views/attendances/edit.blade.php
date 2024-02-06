@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Attendance') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('attendances.update', $attendance->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group row">
                                <label for="kid" class="col-md-4 col-form-label text-md-right">{{ __('Kid') }}</label>
                                <div class="col-md-6">
                                    <input id="kid" type="text" class="form-control" value="{{ $attendance->kid->name }}" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="group" class="col-md-4 col-form-label text-md-right">{{ __('Group') }}</label>
                                <div class="col-md-6">
                                    <input id="group" type="text" class="form-control" value="{{ $attendance->group->name }}" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>
                                <div class="col-md-6">
                                    <input id="date" type="text" class="form-control" value="{{ $attendance->date }}" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>
                                <div class="col-md-6">
                                    <select id="status" class="form-control" name="status">
                                        <option value="1" {{ $attendance->status == 'present' ? 'selected' : '' }}>Present</option>
                                        <option value="0" {{ $attendance->status == 'absent' ? 'selected' : '' }}>Absent</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update') }}
                                    </button>
                                    <a href="{{ route('attendances.index') }}" class="btn btn-secondary">
                                        {{ __('Cancel') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
