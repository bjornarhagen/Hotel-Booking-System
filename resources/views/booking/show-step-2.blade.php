@extends('partials.master')

@section('content')
    @include('booking.nav')
    <form class="room_types" method="post" action="{{ route('hotel.booking.step-2', $hotel->slug) }}">
        {{ csrf_field() }}
        <header>
            <div class="inner-wrapper">
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
            </div>
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
                        @include('booking.show-step-2-room')
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
                    @php
                        $room_classes = 'room busy';
                        
                        if ($loop->index == 0) {
                            $room_classes .= ' first';
                        }

                        $checked =  'disabled';
                    @endphp
                    @foreach ($unavailableRooms as $room)
                        @include('booking.show-step-2-room')
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