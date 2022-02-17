@extends('layout')

@section('app-title', 'Login')

@push('styles')
	<link href="{{ mix('css/login.css') }}" rel="stylesheet">
@endpush

@section('layout-content')

    <main class="login-hero bg-primary vh-100">
        <div class="position-absolute top-50 start-50 translate-middle text-center">

            <div class="mb-5">
                <img class="logo-white logo-3x" src="{{ asset('img/logo.svg') }}" aria-hidden="true" alt="" width="82px" height="16px" />
            </div>

            <!-- List of authenticate-able buttons, links, etc -->
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('auth.google') }}">
                        @include('auth.providers.google')
                    </a>
                </div>
            </div>

        </div>
    </main>

@endsection
