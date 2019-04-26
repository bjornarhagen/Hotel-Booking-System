@extends('partials.master')

@section('content')

<h1>{{ __('Register') }}</h1>
<form method="POST" action="{{ route('register') }}">
    @csrf

    @include('auth.register-fields')

    <div class="form-group">
        <button type="submit">
            {{ __('Register') }}
        </button>
    </div>
</form>

@endsection
