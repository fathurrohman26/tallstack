@extends('layouts.base')

@section('body_classes', 'antialiased bg-gray-100 dark-mode:bg-gray-900')

@section('body')
    @yield('content')

    @isset($slot)
        {{ $slot }}
    @endisset
@endsection
