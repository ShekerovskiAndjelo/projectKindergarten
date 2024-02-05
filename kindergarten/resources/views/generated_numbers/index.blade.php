@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ __('Generated numbers') }}
                    <form method="POST" action="{{ route('generated_numbers.storeRandomNumbers') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary float-right">{{ __('Generate Numbers') }}</button>
                    </form>
                </div>

                <div class="card-body">


                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Number</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($numbers as $number)
                                <tr>
                                    <th scope="row">{{ $number->id }}</th>
                                    <td>{{ $number->number }}</td>
                                    <td>{{ $number->status ? 'Active' : 'Inactive' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $numbers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
