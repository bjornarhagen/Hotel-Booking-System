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

            @php
                $nights = $check_in_date->diffInDays($check_out_date);
            @endphp

            <button type="submit">
                <span>{{ __('Continue') }}</span>
                @icon('chevron-right')
            </button>
        </header>
        @foreach ($room_types as $room_type)
            @php
                $availableRooms = $room_type->availableRooms($check_in_date, $check_out_date);
                $unavailableRooms = $room_type->unavailableRooms($check_in_date, $check_out_date);
            @endphp
            <section class="room_type expand">
                <h2>{{ $room_type->name }}</h2>

                @if ($availableRooms->count() === 0)
                    <p>Ingen ledige rom.</p>
                @else
                    @foreach ($availableRooms as $room)
                        @php
                            $room_classes = 'room available';
                            
                            if ($loop->index == 0) {
                                $room_classes .= ' first';
                            }

                            if (in_array($room->id, old('rooms', session('booking-rooms', [])))) {
                                $checked =  'checked';
                            } else {
                                $checked = null;
                            }

                        @endphp
                        <article class="{{ $room_classes }}">
                            <div class="image" style="background-image: url('{{ asset('images/' . $hotel->slug . '/' . $room->room_type->slug . '.jpg') }}')"></div>
                            <h3 class="name">{{ $room->name }}</h3>
                            <p class="description">{{ $room->room_type->description }}</p>
                            <input id="room-checkbox-{{ $room->id }}"
                                name="rooms[]"
                                type="checkbox"
                                value="{{ $room->id }}"
                                {{ $checked }}
                            >
                            <label class="select" for="room-checkbox-{{ $room->id }}">
                                <p class="price">{{ __('Price') }}: {{ $room->price . ',-' }}</p>
                                @if ($nights > 1)
                                    <p class="price-nights">{{ __('Price for :nights nights', ['nights' => $nights]) }}: {{ ($room->price * $nights) . ',-' }}</p>
                                @endif
                                <p class="button button-primary">
                                    @icon('checkbox-blank', 'not-selected')
                                    @icon('checkbox-checked', 'selected')
                                    <span>{{ __('Select room') }}</span>
                                </p>
                            </label>
                        </article>
                        @if ($loop->first && $loop->remaining > 0)
                            <div class="see-more-button">
                                <button type="button" class="button-blank expand-trigger">
                                    <span>{{ __('See more') }} ({{ $loop->remaining }})</span>
                                    <span>{{ __('See less') }}</span>
                                </button>
                            </div>
                        @endif
                    @endforeach
                @endif
                @if ($unavailableRooms->count() !== 0)
                    @foreach ($unavailableRooms as $room)
                        <article class="room busy">
                            <h3>{{ $room->id }}</h3>
                            <p>Busy</p>
                        </article>
                    @endforeach
                @endif
            </section>
        @endforeach

        <button class="submit" type="submit">
            <span>{{ __('Continue') }}</span>
            @icon('chevron-right')
        </button>
    </form>
    <link href="{{ asset('css/booking-step-2.css') }}" rel="stylesheet">
@endsection