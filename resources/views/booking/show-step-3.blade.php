@extends('partials.master')

@section('content')
    @include('booking.nav')
    
    <section class="auth">
        <div class="inner-wrapper">
            <h1>{{ __('Booking — Identification') }}</h1>

            <h2>{{ __('Login as user') }}</h2>
            <a href="{{ route('login', $hotel->slug) }}">{{ __('Login') }}</a>

            <h2>{{ __('Continue as guest') }}</h2>
            <a href="{{ route('hotel.booking.step-4', $hotel->slug) }}">{{ __('Continue') }}</a>
        </div>
    </section>

    <link href="{{ asset('css/booking-step-3.css') }}" rel="stylesheet">
@endsection