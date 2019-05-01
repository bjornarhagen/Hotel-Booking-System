<nav id="nav-booking">
    <a class="nav-step{{ $step === 1 ? ' nav-step-active' : null }}"
        href="{{ route('hotel.booking.step-1', $hotel->slug) }}"
    >
        {{ __('Step') }} 1
    </a>

    <a class="nav-step{{ $step === 2 ? ' nav-step-active' : null }}"
        href="{{ route('hotel.booking.step-2', $hotel->slug) }}"
    >
        {{ __('Step') }} 2
    </a>

    <a class="nav-step{{ $step === 3 ? ' nav-step-active' : null }}"
        href="{{ route('hotel.booking.step-3', $hotel->slug) }}"
    >
        {{ __('Step') }} 3
    </a>

    <a class="nav-step{{ $step === 4 ? ' nav-step-active' : null }}"
        href="{{ route('hotel.booking.step-4', $hotel->slug) }}"
    >
        {{ __('Step') }} 4
    </a>

</nav>
