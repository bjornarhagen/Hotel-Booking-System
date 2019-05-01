<nav id="nav-main">
    <div id="nav-main-wrapper">
        <div class="nav-left">
            @if (isset($hotel))
                <a class="nav-logo" href="{{ route('site.index') }}">
                    <img class="logo" src="{{ $hotel->brand_logo->url }}" alt="{{ $hotel->name }} logo">
                    <img class="icon" src="{{ $hotel->brand_icon->url }}" alt="{{ $hotel->name }} ikon">
                </a>
            @else
                <a class="nav-link nav-logo" href="{{ route('site.index') }}">
                    <img class="icon-logo" src="{{ config('app.logo') }}" alt="{{ config('app.name') }} logo">
                    <span>{{ config('app.name') }}</span>
                </a>
            @endif
        </div>
        @guest
            <div class="nav-right">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                @if (Route::has('register'))
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                @endif
            </div>
        @endguest
        @auth
            <div class="nav-right">
                {{-- <a class="nav-link" href="{{ route('dashboard.index') }}">{{ __('Dashboard') }}</a> --}}
                @hotel_guest
                    <a class="nav-link" href="#">Mine ordre</a>
                @else
                    <a class="nav-link" href="{{ route('admin.hotel.index') }}">{{ __('Dashboard') }}</a>
                @endhotel_guest
                @php
                    $nav_user = Auth::user();
                @endphp
                <nav class="dropdown">
                    <div class="dropdown-trigger">
                        <img src="{{ $nav_user->image->url }}" alt="{{ __(':name profile picture', ['name' => $nav_user->name_first]) }}">
                        @icon('chevron-down', 'opened')
                        @icon('chevron-up', 'closed')
                    </div>
                    <div class="dropdown-content">
                        <span class="dropdown-content-title">{{ $nav_user->name_first }}</span>
                        <a href="{{ route('user.show') }}">Rediger konto</a>
                        <a
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        >
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </nav>
            </div>
        @endauth
    </div>
</nav>