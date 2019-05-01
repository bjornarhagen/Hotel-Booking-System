<footer id="footer-main">
    <div id="footer-main-wrapper">
        <p>
            @guest
                <a href="{{ route('login') }}">{{ __('Login') }}</a>
                @if (Route::has('register'))
                    <span>|</span>
                    <a href="{{ route('register') }}">{{ __('Register') }}</a>
                @endif
            @endguest
            @auth
                <a href="{{ route('admin.hotel.index') }}">{{ __('Dashboard') }}</a>
                <span>|</span>
                <a href="{{ route('user.show') }}">{{ __('My profile') }}</a>
            @endauth
        </p>
        <p class="copyright">
            <span>{{ __('Source') }}:</span>
            <a href="https://github.com/bjornarhagen/Hotel-Booking-System" noopener noreferrer target="_blank">https://github.com/bjornarhagen/Hotel-Booking-System</a>
            <span>—</span>
            <span>{{ __('A project by') }}</span>
            <a href="https://bjornar.dev" noopener noreferrer target="_blank">Bjørnar Hagen</a>
        </p>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</footer>
