<nav id="nav-main">
    <div id="nav-main-wrapper">
        @guest
            <div class="nav-left">
                <a href="{{ route('site.index') }}">{{ config('app.name') }}</a>
            </div>
            <div class="nav-right">
                <a href="{{ route('login') }}">{{ __('Login') }}</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">{{ __('Register') }}</a>
                @endif
            </div>
        @endguest
        @auth
            <div class="nav-left">
                <a href="{{ route('site.index') }}">
                    <img src="{{ config('app.logo') }}" alt="{{ config('app.name') }} logo">
                    <span>{{ config('app.name') }}</span>
                </a>
            </div>
            <div class="nav-right">
                <a href="{{ route('dashboard.index') }}">{{ __('Dashboard') }}</a>

                @php
                    $nav_user = Auth::user();
                @endphp
                <a href="{{ route('user.show') }}">
                    <img src="{{ $nav_user->image->url }}" alt="{{ __(':name profile picture', ['name' => $nav_user->name]) }}">
                    <span>{{ $nav_user->name }}</span>
                </a>

                @role('admin')
                    <a href="#admin">Admin</a>
                @endrole
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
        @endauth
    </div>
</nav>
