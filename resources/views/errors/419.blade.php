@extends('layouts.error')

@section('title', __('Forbidden'))

@section('content')
    <div class="mb-5 text-white-50">
        <h1 class="display-5 coming-soon-text">
            419
            <br>
            {{ $exception->getMessage() ?: 'Page Expired' }}
        </h1>
        <p class="fs-14">
            {{ __('Sorry, your session has expired. Please refresh and try again.') }}
        </p>
        <div class="mt-4 pt-2">
            <a href="{{ route('home') }}" class="btn btn-success"><i class="mdi mdi-home me-1"></i> Back
                to Home</a>
        </div>
    </div>
@endsection
