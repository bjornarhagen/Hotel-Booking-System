@extends('partials.master')

@section('content')
    <header>
        <h1>{{ __('Bookings') }}</h1>
    </header>

    <hr>

    <section class="bookings">
        @foreach ($hotel->bookings as $booking)
            <article class="booking">
                <header>
                    <h2>{{ $booking->id }}</h2>
                </header>
                @foreach ($booking->data as $booking_data)
                    <section class="booking-row">
                        @include('booking.index-row')
                    </section>
                    <hr>
                @endforeach
                <footer>
                    <div class="summary">
                        <div>{{ $booking->price }}</div>
                        <div>{{ $booking->balance }}</div>
                    </div>
                    <div class="actions">
                        <a href="{{ route('admin.hotel.booking.edit', [$hotel, $booking]) }}">{{ __('Edit') }}</a>
                    </div>
                </footer>
            </article>
        @endforeach
    </section>
@endsection