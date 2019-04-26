@include('partials.head')
<body>
    @include('partials.nav')
    <main>
        <div id="main-wrapper">
            @include('partials.flash-messages')
            @yield('content')
        </div>
    </main>
    @include('partials.footer')
</body>
</html>
