<nav id="nav-booking">
    <a href="{{ route('hotel.booking.step-1', $hotel->slug) }}">{{ __('Step 1') }}</a>
    <a href="{{ route('hotel.booking.step-2', $hotel->slug) }}">{{ __('Step 2') }}</a>
    <a href="{{ route('hotel.booking.step-3', $hotel->slug) }}">{{ __('Step 3') }}</a>
</nav>
<hr>
