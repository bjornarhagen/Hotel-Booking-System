@extends('partials.master')

@section('content')
    <header class="padded-lr padded-tb-half">
        <h1>{{ __('Bookings') }}</h1>
    </header>

    <section class="bookings padded-lr">
        <div class="booking-labels">
            <span class="label">{{ __('User') }}</span>
            <span class="label">{{ __('Room') }}</span>
            <span class="label">{{ __('Check in') }}</span>
            <span class="label">{{ __('Check out') }}</span>
            <span class="label">{{ __('Days') }}</span>
            <span class="label">{{ __('Responsible') }}</span>
            <span class="label">{{ __('Breakfast')[0] }}</span>
            <span class="label">{{ __('Lunch')[0] }}</span>
            <span class="label">{{ __('Dinner')[0] }}</span>
            <span class="label">{{ __('Parking')[0] }}</span>
            {{-- <span class="label">{{ __('Wishes') }}</span>
            <span class="label">{{ __('Price: Wishes') }}</span> --}}
            <span class="label">{{ __('Price: Parking') }}</span>
            <span class="label">{{ __('Price: Meals') }}</span>
            <span class="label">{{ __('Price: Room') }}</span>
            {{-- <span class="label">{{ __('Discount') }}</span>
            <span class="label">{{ __('Balance') }}</span> --}}
        </div>
        @foreach ($hotel->bookings as $booking)
            <article class="booking">
                @foreach ($booking->data as $booking_data)
                    <section class="booking-row">
                        @include('booking.index-row')
                    </section>
                @endforeach
                <footer>
                    <div class="summary">
                        <h2>{{ __('Booking') }}: {{ $booking->id }}</h2>
                        <div>
                            <span class="label">{{ __('Price') }}:</span>
                            <span class="value">{{ $booking->price }}</span>
                        </div>
                        {{-- <div>
                            <span class="label">{{ __('Balance') }}</span>
                            <span class="value">{{ $booking->balance }}</span>
                        </div> --}}
                    </div>
                    <div class="actions">
                        <a class="button button-blank" href="{{ route('admin.hotel.booking.edit', [$hotel, $booking]) }}">
                            @icon('edit')
                            <span>{{ __('Edit') }}</span>
                        </a>
                        <a class="button button-blank" href="{{ route('admin.hotel.booking.delete', [$hotel, $booking]) }}">
                            @icon('delete')
                            <span>{{ __('Delete') }}</span>
                        </a>
                    </div>
                </footer>
            </article>
        @endforeach
    </section>

    <link href="{{ asset('css/booking-admin.css') }}" rel="stylesheet">
@endsection