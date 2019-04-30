@extends('partials.master')

@section('content')
    @include('booking.nav')
    <form class="room_types" method="post" action="{{ route('hotel.booking.step-2', $hotel->slug) }}">
        @csrf
        <header>
            <h1>{{ __('Booking — Pick a room') }}</h1>

            <p>{{ __('People') }}: {{ $people }}</p>
            <p>{{ __('Check in') }}: {{ $check_in_date->format('d. F Y') }}</p>
            <p>{{ __('Check out') }}: {{ $check_out_date->format('d. F Y') }}</p>

            <button type="submit">{{ __('Continue') }}</button>
        </header>
        @foreach ($room_types as $room_type)
            @php
                $availableRooms = $room_type->availableRooms($check_in_date, $check_out_date);
                $unavailableRooms = $room_type->unavailableRooms($check_in_date, $check_out_date);
            @endphp
            <hr>
            <section>
                <h3>{{ $room_type->name }}</h3>

                @if ($availableRooms->count() === 0)
                    <p>Ingen ledige rom.</p>
                @else
                    @foreach ($availableRooms as $room)
                        <article class="available{{ $loop->first ? 'first' : null }}">
                            <h3>
                                <label for="room-checkbox-{{ $room->id }}">{{ $room->name }}</label>
                                <input id="room-checkbox-{{ $room->id }}"
                                name="rooms[]"
                                type="checkbox"
                                value="{{ $room->id }}"
                                {{ in_array($room->id, old('rooms', session('booking-rooms', []))) ? 'checked' : null }}>
                            </h3>
                            <p>{{ __('Price') }}: {{ $room->price . ',-' }}</p>
                            <p>Available</p>

                            @if ($loop->first)
                                <button type="button">Se flere ({{ $loop->remaining }})</button>
                            @endif
                        </article>
                    @endforeach
                @endif
                @if ($unavailableRooms->count() !== 0)
                    <hr>
                    @foreach ($unavailableRooms as $room)
                        <article class="busy">
                            <h3>{{ $room->id }}</h3>
                            <p>Busy</p>
                        </article>
                    @endforeach
                @endif
            </section>
        @endforeach
    </form>
@endsection