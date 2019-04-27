@extends('partials.master')

@section('content')
    <header>
        <h1>{{ __('Hotels') }}</h1>
    </header>

    <section>
        <a href="{{ route('admin.hotel.create') }}">{{ __('Add new :resource', ['resource' => __('hotel')]) }}</a>
    </section>

    <hr>

    <section>
        @foreach ($hotels as $hotel)
            <h2>{{ $hotel->name }}</h2>
            <img src="{{ $hotel->brand_icon->url }}" alt="{{ $hotel->name }} {{ __('icon') }}">
            <nav>
                <a href="{{ route('hotel.show', $hotel->slug) }}">{{ __('Show') }}</a>
                <a href="{{ route('admin.hotel.room.index', $hotel) }}">{{ __('Rooms') }}</a>
                <a href="{{ route('admin.hotel.booking.index', $hotel) }}">{{ __('Bookings') }}</a>
                @hotel_role($hotel, 'hotel_manager')
                    <span>|</span>
                    <a href="{{ route('admin.hotel.edit', $hotel) }}">{{ __('Edit') }}</a>
                    <a href="{{ route('admin.hotel.delete', $hotel) }}">{{ __('Delete') }}</a>
                @endhotel_role
            </nav>
        @endforeach
    </section>
@endsection