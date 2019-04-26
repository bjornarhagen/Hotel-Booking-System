@extends('partials.master')

@section('content')

<h1>{{ __('Reset Password') }}</h1>
<form method="POST" action="{{ route('password.update') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="form-group">
        <label for="email">{{ __('E-Mail Address') }}</label>
        <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus>
    </div>

    <div class="form-group">
        <label for="password">{{ __('Password') }}</label>
        <input id="password" type="password" name="password" required>
    </div>

    <div class="form-group">
        <label for="password-confirm">{{ __('Confirm Password') }}</label>
        <input id="password-confirm" type="password" name="password_confirmation" required>
    </div>

    <div class="form-group">
        <button type="submit">
            {{ __('Reset Password') }}
        </button>
    </div>
</form>

@endsection
