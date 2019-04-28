@extends('partials.master')

@section('content')
    <header>
        <h1>{{ __('Booking — Pick a room') }}</h1>
        <p>{{ __('Check in') }}: {{ $check_in_date->format('d. F Y') }}</p>
        <p>{{ __('Check out') }}: {{ $check_out_date->format('d. F Y') }}</p>
    </header>
    @foreach ($rooms as $room)
        <article>
            <h2>{{ $room->name }}</h2>

            @if ($room->isAvailable($check_in_date, $check_out_date))
                <p>Available</p>
            @else
                <p>Busy</p>
            @endif
        </article>
    @endforeach
@endsection