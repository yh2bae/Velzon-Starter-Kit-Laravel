@extends('layouts.error')

@section('title', __('Forbidden'))

@section('content')
    <div class="mb-5 text-white-50">
        <h1 class="display-5 coming-soon-text">
            402
            <br>
            Payment Required
        </h1>
        <p class="fs-14">
            Payment Required
        </p>
        <div class="mt-4 pt-2">
            <a href="{{ route('home') }}" class="btn btn-success"><i class="mdi mdi-home me-1"></i> Back
                to Home</a>
        </div>
    </div>
@endsection
