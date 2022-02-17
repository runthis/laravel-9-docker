@extends('layouts.app')

@section('app-title', 'Home')

@push('styles')
	<link href="{{ mix('css/home.css') }}" rel="stylesheet">
@endpush

@section('app-content')
    Hello
@endsection
