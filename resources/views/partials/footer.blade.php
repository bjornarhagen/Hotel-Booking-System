<footer id="footer-main">
    <div id="footer-main-wrapper">
        <p>
            <a href="#personvern" target="_blank" rel="noopener">Personvern</a>
            <span>|</span>
            <a href="{{ route('login') }}">{{ __('Login') }}</a>
            @if (Route::has('register'))
                <span>|</span>
                <a href="{{ route('register') }}">{{ __('Register') }}</a>
            @endif
            <span>|</span>
            <a href="{{ route('dashboard.index') }}">{{ __('Dashboard') }}</a>
            <span>|</span>
            <a href="{{ route('user.show') }}">{{ __('My profile') }}</a>
        </p>
    <p class="copyright">
        <a href="https://github.com/bjornarhagen/Hotel-Booking-System" noopener noreferrer target="_blank">{{ config('app.name') }}</a>
        <span>—</span>
        <span>A school project by</span>
        <a href="https://bjornar.dev" noopener noreferrer target="_blank">Bjørnar Hagen</a>
    </p>
    </div>
</footer>
